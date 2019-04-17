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

class Tokenizer
{
	/** @var Input */
	private $input;

	public function tokenize(Input $input)
	{
		$this->input = $input;

		$this->getTokens($output);

		return $output;
	}

	private function getTokens(array &$output = null)
	{
		$output = [];

		while ($this->getToken($token)) {
			$output[] = $token;
			unset($token);
		}

		return true;
	}

	private function getToken(Token &$token = null)
	{
		return $this->getWord($token) ||
			$this->getHorizontalWhitespace($token) ||
			$this->getVerticalWhitespace($token);
	}

	private function getWord(Token &$token = null)
	{
		if (!$this->input->getRe('\\S+', $value)) {
			return false;
		}

		$token = new Token(Token::WORD, $value);
		return true;
	}

	private function getHorizontalWhitespace(Token &$token = null)
	{
		if (!$this->input->getRe('\\h+', $value)) {
			return false;
		}

		$token = new Token(Token::HORIZONTAL_WHITESPACE, $value);
		return true;
	}

	private function getVerticalWhitespace(Token &$token = null)
	{
		if (!$this->input->getRe('\\v+', $value)) {
			return false;
		}

		$token = new Token(Token::VERTICAL_WHITESPACE, $value);
		return true;
	}
}
