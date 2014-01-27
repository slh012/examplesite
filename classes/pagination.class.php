<?php
// show all page numbers
define('STYLE_ALL_NUMBERS',1);
// show only the relevant ten page numbers
define('STYLE_ONE_TO_TEN',2);

class pagination
{
	/*
	 * Total number of items/rows in list.
	 *
	 * @type integer
	 * @access protected
	 * @see total()
	 */
	protected $total_items;

	/*
	 * Number of items being used per page.
	 *
	 * @type integer
	 * @access protected
	 * @see perPage()
	 */
	protected $per_page;

	/*
	 * Current page number we're on.
	 *
	 * @type integer
	 * @access protected
	 * @see startPage()
	 */
	protected $current_page;


	/*
	 * construction
	 */
	function __construct($page, $query)
	{
		$this->total_items = 0;
		$this->per_page = 0;
		$this->current_page = 1;

		unset($query['page']);
		unset($query['Submit']);

		array_walk($query, create_function('$x', 'return htmlspecialchars($x, ENT_QUOTES);'));
		$this->page_url = $page . '?' . http_build_query($query);
	}


	public function currentPage($page)
	{
		$this->current_page = $page;
	}

	/*
	 * Set the total number of items in the list.
	 *
	 * @param integer total
	 * @access public
	 * @returns void
	 * @see $total_items
	 */
	public function total($total)
	{
		$this->total_items = abs((int) $total);
	}

	/*
	 * Set the number of items being used per page.
	 *
	 * @param integer per_page
	 * @access public
	 * @returns void
	 * @see $per_page
	 */
	public function perPage($per_page)
	{
		$this->per_page = abs((int) $per_page);
	}

	public function getFirstLink($title)
	{
		if ($this->total_items > $this->per_page && $this->current_page > 1)
		{
			return "<li><a href=\"$this->page_url&page=1\">$title</a></li>";
		}
		else
		{
			return ;
		}
	}

	public function getLastLink($title)
	{
		$page = ceil($this->total_items / $this->per_page);
		if ($this->total_items > $this->per_page && $this->current_page < $page)
		{
			return "<li><a href=\"$this->page_url&page=$page\">$title</a></li>";
		}
		else
		{
			return ;
		}
	}

	public function getPrevLink($title)
	{
		if ($this->total_items > $this->per_page && $this->current_page > 1)
		{
			$page = $this->current_page - 1;
			return "<li><a href=\"$this->page_url&page=$page\">$title</a></li>";
		}
		else
		{
			return ;
		}
	}

	public function getNextLink($title)
	{
		if ($this->total_items > $this->per_page && $this->current_page >= 1 && $this->current_page < ceil($this->total_items / $this->per_page))
		{
			$page = $this->current_page + 1;
			return "<li><a href=\"$this->page_url&page=$page\">$title</a></li>";
		}
		else
		{
			return ;
		}
	}


	/*
	 * Print the pagination results.
	 *
	 * @access public
	 * @returns void
	 */
	public function build()
	{
		if ($this->total_items > $this->per_page)
		{
			$pages = ceil($this->total_items / $this->per_page);


			if ($this->current_page < 6)
			{
				$addition = 11 - $this->current_page;
			}
			else
			{
				$addition = 6;
			}

			$items = $this->current_page + $addition;
			$i = $this->current_page - 4;

			if ($i < 1 )
			{
				$i = 1;
			}

			if ($items > $pages)
			{
				$items = $pages + 1;
			}

			$ret = '';
			for ( ; $i < $items; $i++)
			{
				$ret .= ($i == $this->current_page) ? "<li class=\"active\"><a href=\"#\">$i</a></li>" : "<li><a href=\"$this->page_url&page=$i\">$i</a> </li>\n";
			}

			return $ret;
		}
	}

}
?>