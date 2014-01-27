<?php


abstract class search implements formatResult
{
	protected $order_by;
	protected $found_rows = 0;
	protected $limit_start = 0;
	protected $current_page = 1;
	protected $results_per_page = 25;
	public $search_params = array();

	abstract public function query();
	abstract public function getResultSetNums();
	abstract public function addSearchParam($k, $v);


	public function getSearchParam($key = '')
	{
		if (!empty($key))
		{
			return $this->search_params[$key];
		}
		else
		{
			return $this->search_params;
		}
	}
        
        public function setResultsPerPage($results_per_page)
	{
		$this->results_per_page = $results_per_page;
	}

	public function getResultsPerPage()
	{
		return $this->results_per_page;
	}

	public function getCurrentPageNum()
	{
		return $this->current_page;
	}

	public function foundRows()
	{
		return $this->found_rows;
	}

	protected function page($page_num)
	{
		$this->current_page = abs((int) $page_num);
	}
}

?>