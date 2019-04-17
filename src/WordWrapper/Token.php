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

class Token
{
	const WORD = 1;
	const HORIZONTAL_WHITESPACE = 2;
	const VERTICAL_WHITESPACE = 3;

	private $type;
	private $value;

	public function __construct(int $type, string $value)
	{
		$this->type = $type;
		$this->value = $value;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getValue()
	{
		return $this->value;
	}
}
