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

class TableMaker
{
	/** @var array */
	private $edges;

	/**
	 * @param array|null $edges
	 */
	public function __construct(array $edges = null)
	{
		if ($edges === null) {
			$edges = [
				[' ╭─', '─┬─', '─╮ ', '─'],
				[' │ ', ' │ ', ' │ ', ' '],
				[' ╞═', '═╪═', '═╡ ', '═'],
				[' │ ', ' │ ', ' │ ', ' '],
				[' ╰─', '─┴─', '─╯ ', '─']
			];
		}

		$this->edges = $edges;
	}

	public function getText(array $headers, array $rows)
	{
		$widths = $this->getWidths($headers, $rows);

		$lines = [
			$this->getEdgeText($widths, $this->edges[0]),
			$this->getRowText($headers, $widths, $this->edges[1]),
			$this->getEdgeText($widths, $this->edges[2]),
		];

		foreach ($rows as $row) {
			$lines[] = $this->getRowText($row, $widths, $this->edges[3]);
		}

		$lines[] = $this->getEdgeText($widths, $this->edges[4]);

		return implode("\n", $lines) . "\n";
	}

	private function getWidths(array $headers, array $rows)
	{
		$widths = [];

		foreach ($headers as $key => $value) {
			$widths[$key] = strlen($value);
		}

		foreach ($rows as $row) {
			foreach ($widths as $key => $width) {
				$widths[$key] = max($width, strlen($row[$key]));
			}
		}

		return $widths;
	}

	private function getEdgeText(array $widths, array $edges)
	{
		$output = [];

		foreach ($widths as $width) {
			$output[] = str_repeat($edges[3], $width);
		}

		return $edges[0] . implode($edges[1], $output) . $edges[2];
	}

	private function getRowText(array $values, array $widths, array $edges)
	{
		$output = [];

		foreach ($widths as $key => $width) {
			$output[] = str_pad($values[$key], $width, $edges[3]);
		}

		return $edges[0] . implode($edges[1], $output) . $edges[2];
	}
}