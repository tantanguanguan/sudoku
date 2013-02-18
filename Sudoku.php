<?php
include('Cell.php');

class Sudoku 
{
	var $board = array();
	var $certainty = 0;

	function Sudoku($numbers)
	{
		foreach($numbers as $key => $number)
		{
			$this->board[$key[1]][$key[2]] = new Cell($key[1], $key[2], $number);
			if($number != null)
			{
				$this->certainty++;
			}
		}
		$this->initilizeBoard();
	}

	function loopBoard()
	{
		while ($this->certainty < 81)
		{
			$nextCell = $this->findNextCell();
			if($nextCell->getPossiblesNumber() > 1)
			{
				echo 'certainty: ' . $this->certainty;
				print_r($nextCell);
				$this->printBoard();
				exit();
			}
		}
		$this->printBoard();
	}

	function findNextCell()
	{
		$min = 9;
		$nextCell = null;
		foreach ($this->board as $row => $cols)
		{
			foreach ($cols as $col => $cell) 
			{
				$numOfPossibles = $cell->getPossiblesNumber();
				if($numOfPossibles < $min && $numOfPossibles != 0)
				{
					$min = $numOfPossibles;
					$nextCell = $cell;
				}
			}
		}
		return $nextCell;
	}

	function initilizeBoard()
	{
		foreach ($this->board as $row => $cols)
		{
			foreach ($cols as $col => $cell) 
			{
				$this->lookUpCell($cell);
			}
		}
	}

	function lookUpCell($cell)
	{
		// undetermined cell
		if($cell->value == 0)
		{
			$this->lookUpRow($cell);
			$this->lookUpCol($cell);
			$this->lookUpGroup($cell);
		}
	}

	function selfRemove($cell)
	{
		$this->selfRemoveRow($cell);
		$this->selfRemoveCol($cell);
		$this->selfRemoveGroup($cell);
	}

	function eliminate($cellA, $cellB)
	{
		if($cellA->eliminate($cellB) !== false)
		{
			$this->certainty++;
			$this->selfRemove($cellA);
		}
	}

	function lookUpRow($cell)
	{
		foreach ($this->board[$cell->row] as $col => $neighbourCell) 
		{
			$this->eliminate($cell, $neighbourCell);
		}
	}

	function selfRemoveRow($cell)
	{
		foreach ($this->board[$cell->row] as $col => $neighbourCell) 
		{
			$this->eliminate($neighbourCell, $cell);
		}
	}

	function lookUpCol($cell)
	{
		for($row = 1; $row <= 9; $row++)
		{
			$this->eliminate($cell, $this->board[$row][$cell->col]);
		}
	}

	function selfRemoveCol($cell)
	{
		for($row = 1; $row <= 9; $row++)
		{
			$this->eliminate($this->board[$row][$cell->col], $cell);
		}
	}

	function lookUpGroup($cell)
	{
		$i = $this->_getInitNumberInGroup($cell->row);
		$j = $this->_getInitNumberInGroup($cell->col);
		for($row = $i; $row <= $i+2; $row++)
		{
			for($col = $j; $col <= $j+2; $col++)
			{
				$this->eliminate($cell, $this->board[$row][$col]);
			}
		}
	}

	function selfRemoveGroup($cell)
	{
		$i = $this->_getInitNumberInGroup($cell->row);
		$j = $this->_getInitNumberInGroup($cell->col);
		for($row = $i; $row <= $i+2; $row++)
		{
			for($col = $j; $col <= $j+2; $col++)
			{
				$this->eliminate($this->board[$row][$col], $cell);
			}
		}
	}

	function printBoard()
	{
		for($row = 1; $row <= 9; $row++)
		{
			for($col = 1; $col <= 9; $col++)
			{
				$cell = $this->board[$row][$col];
				echo $cell->value . ' ';
			}
			echo "\n";
		}
	}

	function _getInitNumberInGroup($val)
	{
		if($val <= 3)
		{
			return 1;
		} 
		else if ($val <= 6)
		{
			return 4;
		}
		else 
		{
			return 7;
		}
	}

}