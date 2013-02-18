<?php
class Cell
{
	var $value = 0;
	var $row;
	var $col;
	var $possibles = array(1, 2, 3, 4, 5, 6, 7, 8, 9);

	function Cell($row, $col, $value = null)
	{
		$this->row = $row;
		$this->col = $col;
		if($value != null)
		{
			$this->value = $value;
			$this->possibles = array();
		}
	}

	function eliminate($cell)
	{
		if($cell->value != 0 && $this->value == 0)
		{
			$this->removeFromPossibles($cell->value);
			return $this->shouldFill();
			
		}
		return false;
	}

	function shouldFill()
	{
		if($this->getPossiblesNumber() == 1)
		{
			$this->value = reset($this->possibles);
			$this->possibles = array();
			return true;
		}
		return false;
	}

	function getPossiblesNumber()
	{
		return count($this->possibles);
	}

	function removeFromPossibles($value)
	{
		if(($key = array_search($value, $this->possibles)) !== false)
		{
			unset($this->possibles[$key]);
		}
	}
}