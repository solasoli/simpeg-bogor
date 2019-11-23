<?php
class Paginator{
	var $items_per_page;
	var $items_total;
	var $current_page;
	var $num_pages;
	var $mid_range;
	var $low;
	var $high;
	var $limit;
	var $posisi;
	var $return;
	var $default_ipp = 10;
	var $querystring;
	var $loadPage;

    function __construct(){
        $this->current_page = 0;
        $this->mid_range = 5;
        $this->items_per_page = (!empty($_POST['ipp'])) ? $_POST['ipp']:$this->default_ipp;
    }
	
	function setLoadPage($page)
	{
		$this->loadPage = $page;
	}

	function paginate()
	{
		if($_POST['ipp'] == 'All')
		{
			$this->num_pages = ceil($this->items_total/$this->default_ipp);
			$this->items_per_page = $this->default_ipp;
		}
		else
		{
			if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
			$this->num_pages = ceil($this->items_total/$this->items_per_page);
		}
		$this->current_page = (int) $_POST['page']; // must be numeric > 0
		if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 0;
		if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
		$prev_page = $this->current_page-1;
		$next_page = $this->current_page+1;

		if($_POST){
			$args = explode("&",$_SERVER['QUERY_STRING']);
			foreach($args as $arg)
			{
				$keyval = explode("=",$arg);
				if($keyval[0] != "page" And $keyval[0] != "ipp") $this->querystring .= "&" . $arg;
			}
		}

		if($_POST)
		{
			foreach($_POST as $key=>$val)
			{
				if($key != "page" And $key != "ipp") $this->querystring .= "&$key=$val";
			}
		}

		if($this->num_pages > 5)
		{
			
			//========================= paging
			
			//$this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?page=$prev_page&ipp=$this->items_per_page$this->querystring\">&laquo; Previous</a> ":"<span class=\"inactive\" href=\"#\">&laquo; Previous</span> ";

			$this->return = ($this->current_page > 1 And $this->items_total >= 10) ? "<button type=\"button\" id=\"btnPaging_previous\" onclick=\"pagingViewListLoad($prev_page,'$this->items_per_page$this->querystring');\" class=\"button primary bg-gray small\" style='border: solid 1px grey;'>&nbsp;&laquo; Previous&nbsp;</button>":"<button type=\"button\" style=\"opacity: 0.6; pointer-events: none;border: solid 1px grey;\" class=\"button primary bg-gray small\"> &laquo; Previous </button>";


			//=========================== 

			$this->start_range = $this->current_page - floor($this->mid_range/2);
			$this->end_range = $this->current_page + floor($this->mid_range/2);

			if($this->start_range <= 0)
			{
				$this->end_range += abs($this->start_range)+1;
				$this->start_range = 1;
			}
			if($this->end_range > $this->num_pages)
			{
				$this->start_range -= $this->end_range-$this->num_pages;
				$this->end_range = $this->num_pages;
			}
			$this->range = range($this->start_range,$this->end_range);


			//========================================================================= paging


			for($i=1;$i<=$this->num_pages;$i++)
			{
				if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= "<button type=\"button\" style=\"opacity: 0.6; pointer-events: none;\" class=\"button primary bg-gray small\"> ... </button>";
				// loop through all pages. if first, last, or in range, display
				if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
				{
					//$this->return .= ($i == $this->current_page And $_POST['page'] != 'All') ? "<a title=\"Go to page $i of $this->num_pages\" class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"$_SERVER[PHP_SELF]?page=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";
					if($i==1){
					    if($this->current_page==0){
                            $this->return .= ($_POST['page'] != 'All') ? "<button type=\"button\" style=\"opacity: 0.6; pointer-events: none; border: solid 1px grey;/*background-color: orange;*/border: solid 1px grey;\" class=\"button primary bg-orange small\">$i</button>":"<button type=\"button\" id=\"btnPaging_$i\" onclick=\"pagingViewListLoad($i,'$this->items_per_page$this->querystring');\" class=\"button primary bg-gray small\" style='border: solid 1px grey;'>&nbsp;$i&nbsp;</button>";
                        }else{
                            $this->return .= ($i == $this->current_page And $_POST['page'] != 'All') ? "<button type=\"button\" style=\"opacity: 0.6; pointer-events: none; border: solid 1px grey;/*background-color: orange;*/border: solid 1px grey;\" class=\"button primary bg-orange small\">$i</button>":"<button type=\"button\" id=\"btnPaging_$i\" onclick=\"pagingViewListLoad($i,'$this->items_per_page$this->querystring');\" class=\"button primary bg-gray small\" style='border: solid 1px grey;'>&nbsp;$i&nbsp;</button>";
                        }
                    }else{
                        $this->return .= ($i == $this->current_page And $_POST['page'] != 'All') ? "<button type=\"button\" style=\"opacity: 0.6; pointer-events: none; border: solid 1px grey;/*background-color: orange;*/border: solid 1px grey;\" class=\"button primary bg-orange small\">$i</button>":"<button type=\"button\" id=\"btnPaging_$i\" onclick=\"pagingViewListLoad($i,'$this->items_per_page$this->querystring');\" class=\"button primary bg-gray small\" style='border: solid 1px grey;'>&nbsp;$i&nbsp;</button>";
                    }

				}
				
				if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= "<button type=\"button\" style=\"opacity: 0.6; pointer-events: none; border: solid 1px grey; \" class=\"button primary bg-gray small\"> ... </button>";
			}
			
			//$this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_POST['page'] != 'All')) ? "<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?page=$next_page&ipp=$this->items_per_page$this->querystring\">Next &raquo;</a>\n":"<span class=\"inactive\" href=\"#\">&raquo; Next</span>\n";
            if($this->current_page==0){
                $this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_POST['page'] != 'All')) ? "<button type=\"button\" id=\"btnPaging_next\" onclick=\"pagingViewListLoad(2,'$this->items_per_page$this->querystring');\" class=\"button primary bg-gray small\" style='border: solid 1px grey;'>&nbsp;Next &raquo;&nbsp;</button>\n":"<button type=\"button\" style=\"opacity: 0.6; pointer-events: none;border: solid 1px grey;\" class=\"button primary bg-gray small\">&raquo; Next</button>\n";
            }else{
                $this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_POST['page'] != 'All')) ? "<button type=\"button\" id=\"btnPaging_next\" onclick=\"pagingViewListLoad($next_page,'$this->items_per_page$this->querystring');\" class=\"button primary bg-gray small\" style='border: solid 1px grey;'>&nbsp;Next &raquo;&nbsp;</button>\n":"<button type=\"button\" style=\"opacity: 0.6; pointer-events: none;border: solid 1px grey;\" class=\"button primary bg-gray small\">&raquo; Next</button>\n";
            }
			
			//$this->return .= ($_POST['page'] == 'All') ? "<a class=\"current\" style=\"margin-left:10px\" href=\"#\">All</a> \n":"<a class=\"paginate\" style=\"margin-left:10px\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">All</a> \n";
			
			//$this->return .= ($_POST['page'] == 'All') ? "<a class=\"current\" style=\"margin-left:10px\" href=\"#\" >All</a> \n":"<button type=\"button\" id=\"btnPaging_all\"  onclick=\"pagingViewListLoad(1,'All$this->querystring');\">&nbsp;All&nbsp;</button> \n";
			
			//=========================================================================== 
			
		}
		else
		{
			
			//============================================================================= paging
				
			for($i=1;$i<=$this->num_pages;$i++)
			{
				//$this->return .= ($i == $this->current_page) ? "<a class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?page=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";
				
				//$this->return .= ($i == $this->current_page) ? "<button type=\"button\" style=\"opacity: 0.6; pointer-events: none; /*background-color: orange;*/ border: solid 1px grey;\" class=\"button primary bg-orange small\">$i</button> ":"<button type=\"button\" id=\"btnPaging_$i\" onclick=\"pagingViewListLoad($i,'$this->items_per_page$this->querystring');\" style='border: solid 1px grey;' class=\"button primary bg-gray small\">&nbsp;$i&nbsp;</button> ";

                if($i==1){
                    if($this->current_page==0){
                        $this->return .= ($_POST['page'] != 'All') ? "<button type=\"button\" style=\"opacity: 0.6; pointer-events: none; border: solid 1px grey;/*background-color: orange;*/border: solid 1px grey;\" class=\"button primary bg-orange small\">$i</button>":"<button type=\"button\" id=\"btnPaging_$i\" onclick=\"pagingViewListLoad($i,'$this->items_per_page$this->querystring');\" class=\"button primary bg-gray small\" style='border: solid 1px grey;'>&nbsp;$i&nbsp;</button>";
                    }else{
                        $this->return .= ($i == $this->current_page And $_POST['page'] != 'All') ? "<button type=\"button\" style=\"opacity: 0.6; pointer-events: none; border: solid 1px grey;/*background-color: orange;*/border: solid 1px grey;\" class=\"button primary bg-orange small\">$i</button>":"<button type=\"button\" id=\"btnPaging_$i\" onclick=\"pagingViewListLoad($i,'$this->items_per_page$this->querystring');\" class=\"button primary bg-gray small\" style='border: solid 1px grey;'>&nbsp;$i&nbsp;</button>";
                    }
                }else{
                    $this->return .= ($i == $this->current_page And $_POST['page'] != 'All') ? "<button type=\"button\" style=\"opacity: 0.6; pointer-events: none; border: solid 1px grey;/*background-color: orange;*/border: solid 1px grey;\" class=\"button primary bg-orange small\">$i</button>":"<button type=\"button\" id=\"btnPaging_$i\" onclick=\"pagingViewListLoad($i,'$this->items_per_page$this->querystring');\" class=\"button primary bg-gray small\" style='border: solid 1px grey;'>&nbsp;$i&nbsp;</button>";
                }

			}
			//$this->return .= "<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">All</a> \n";
			//$this->return .= "<button type=\"button\" class=\"btnGen\" id=\"btnPaging_all\" onclick=\"pagingViewListLoad(1,'All$this->querystring');\" onmousedown=\"btnMouseD(this.id);\" onmouseout=\"btnMouseU(this.id);\" onmouseup=\"btnMouseU(this.id);\">&nbsp;All&nbsp;</button>  \n";
					
			//============================================================================== 
			
		}
		$this->low = ($this->current_page-1) * $this->items_per_page;
		$this->high = ($_POST['ipp'] == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;
		$this->limit = ($_POST['ipp'] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
		$this->posisi = ($this->current_page-1) * $this->items_per_page;
	}
	
	function display_items_per_page()
	{
		$items = '';
		$ipp_array = array(10,25,50,100,'All'); //'All'
		foreach($ipp_array as $ipp_opt)	$items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";
		//return "<span class=\"paginate\">Item per halaman:</span><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?page=1&ipp='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n";
		return "<span class=\"paginate\">Item per halaman:</span><select onchange=\"pagingViewListLoad(1,this[this.selectedIndex].value+'$this->querystring');return false\">$items</select>\n";
	}

	function display_jump_menu()
	{
		$option = '<option value="0" '.($this->current_page==0?'selected':'').'>Lompat ke halaman :</option>';
		for($i=1;$i<=$this->num_pages;$i++)
		{
			$option .= ($i==$this->current_page) ? "<option value=\"$i\" ".($this->current_page==0?'':'selected').">Halaman $i</option>\n":"<option value=\"$i\">Halaman $i</option>\n";
		}
		//return "<span class=\"paginate\">Halaman:</span><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?page='+this[this.selectedIndex].value+'&ipp=$this->items_per_page$this->querystring';return false\">$option</select>\n";
		return "<span class=\"paginate\"></span><select onchange=\"pagingViewListLoad(this[this.selectedIndex].value,'$this->items_per_page$this->querystring');return false\">$option</select>\n";
	}

	function display_pages()
	{
		return $this->return;
	}
}