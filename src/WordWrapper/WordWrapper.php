<?php

/**
 * Copyright (C) 2019 Spencer Mortensen
 *
 * This file is part of Command.
 *
 * Command is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Command is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Command. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Spencer Mortensen <spencer@lens.guide>
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL-3.0
 * @copyright 2019 Spencer Mortensen
 */

namespace SpencerMortensen\Command\WordWrapper;

class WordWrapper
{
	/** @var int */
	private $maximumLength;

	/** @var Tokenizer */
	private $tokenizer;

	/** @var array */
	private $output;

	/** @var int */
	private $position;

	public function __construct(int $maximumLength = 80)
	{
		$this->maximumLength = $maximumLength;
		$this->tokenizer = new Tokenizer();
	}

	public function wrap(string $string): string
	{
		$input = new Input($string);
		$tokens = $this->tokenizer->tokenize($input);

		$this->output = [];
		$this->position = 0;

		foreach ($tokens as $i => $token) {
			switch ($token->getType()) {
				case Token::WORD:
					$this->getWord($token);
					break;

				case Token::HORIZONTAL_WHITESPACE:
					$nextToken = $tokens[$i + 1] ?? null;
					$this->getHorizontalWhitespace($token, $nextToken);
					break;

				case Token::VERTICAL_WHITESPACE:
					$this->getVerticalWhitespace($token);
					break;
			}
		}

		return $this->getText();
	}

	private function getWord(Token $token)
	{
		$this->output[] = $token;
		$this->position += $this->getWordLength($token->getValue());
	}

	private function getHorizontalWhitespace(Token $token, Token $nextToken = null)
	{
		if (($nextToken === null) || ($nextToken->getType() !== Token::WORD)) {
			return;
		}

		$tokenLength = $this->getHorizontalWhitespaceLength($token->getValue());
		$nextTokenLength = $this->getWordLength($nextToken->getValue());

		if (($this->position === 0) || ($this->position + $tokenLength + $nextTokenLength <= $this->maximumLength)) {
			$this->output[] = $token;
			$this->position += $tokenLength;
		} else {
			$this->output[] = new Token(Token::VERTICAL_WHITESPACE, PHP_EOL);
			$this->position = 0;
		}
	}

	private function getVerticalWhitespace(Token $token)
	{
		$this->output[] = $token;
		$this->position = 0;
	}

	private function getWordLength(string $word)
	{
		return strlen($word);
	}

	private function getHorizontalWhitespaceLength(string $whitespace)
	{
		return strlen($whitespace) + 3 * substr_count($whitespace, "\t");
	}

	private function getText()
	{
		ob_start();

		foreach ($this->output as $token) {
			echo $token->getValue();
		}

		return ob_get_clean();
	}

	public function getMaximumLength()
	{
		return $this->maximumLength;
	}

	public function setMaximumLength(int $maximumLength)
	{
		$this->maximumLength = $maximumLength;
	}
}