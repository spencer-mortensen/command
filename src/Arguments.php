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

namespace SpencerMortensen\Command;

class Arguments
{
	/** @var string */
	private $executable;

	/** @var array */
	private $options;

	/** @var array */
	private $values;

	public function __construct()
	{
		self::read($GLOBALS['argv']);
	}

	public function getExecutable()
	{
		return $this->executable;
	}

	public function getOptions()
	{
		return $this->options;
	}

	public function getValues()
	{
		return $this->values;
	}

	private function read(array $arguments)
	{
		$this->options = [];
		$this->values = [];
		$this->executable = array_shift($arguments);

		foreach ($arguments as $argument) {
			$this->getLongOption($argument) ||
			$this->getShortOption($argument) ||
			$this->getValue($argument);
		}
	}

	private function getLongOption(string $argument): bool
	{
		$pattern = '~^--(?<key>[a-z-]+)(?:=(?<value>.*))?$~XADs';

		if (preg_match($pattern, $argument, $match) !== 1) {
			return false;
		}

		$key = $match['key'];
		$value = $match['value'] ?? true;

		$this->options[$key] = $value;

		return true;
	}

	private function getShortOption(string $argument): bool
	{
		$pattern = '~^-(?<keys>[a-z-]+)(?:=(?<value>.*))?$~XADs';

		if (preg_match($pattern, $argument, $match) !== 1) {
			return false;
		}

		$keys = str_split($match['keys']);
		$value = $match['value'] ?? true;

		foreach ($keys as $key) {
			$this->options[$key] = true;
		}

		$this->options[$key] = $value;

		return true;
	}

	private function getValue(string $argument): bool
	{
		$this->values[] = $argument;
		return true;
	}
}
