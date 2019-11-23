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
    var $tbl;
    var $custome_default_ipp = 0;

    function Paginator()
    {
        $this->current_page = 1;
        $this->mid_range = 5;
        $this->tbl = @$_POST['tbl'];
    }

    function setLoadPage($page)
    {
        $this->loadPage = $page;
    }

    function setCustomeDefaultIpp($ipp){
        $this->custome_default_ipp = $ipp;
    }

    function paginate()
    {
        if($this->custome_default_ipp>0){
            $this->items_per_page = $this->custome_default_ipp;
        }else{
            $this->items_per_page = (!empty($_POST['ipp'])) ? $_POST['ipp']:$this->default_ipp;
        }
        //echo "items_per_page".$this->items_per_page;
        if(isset($_POST['ipp']) and $_POST['ipp'] == 'All')
        {
            $this->num_pages = ceil($this->items_total/$this->default_ipp);
            $this->items_per_page = $this->default_ipp;
        }
        else
        {
            if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
            $this->num_pages = ceil($this->items_total/$this->items_per_page);
        }
        //echo "<br>POST['page']: ".(isset($_POST['page'])?$_POST['page']:1);
        $this->current_page = (int) (isset($_POST['page'])?$_POST['page']:1) ; // must be numeric > 0
        if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
        if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
        $prev_page = $this->current_page-1;
        $next_page = $this->current_page+1;
        //echo "<br>current_page: ".$this->current_page;
        if($_POST)
        {
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

            $this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<button id=\"".$this->tbl."_btnPaging_previous\" onclick=\"pagingViewListLoad($prev_page,'$this->items_per_page','$this->tbl');\">&nbsp;&laquo; Previous&nbsp;</button>":"<button style=\"opacity: 0.6; pointer-events: none;\"> &laquo; Previous </button>";


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
                if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= "<button style=\"opacity: 0.6; pointer-events: none;\"> ... </button>";
                // loop through all pages. if first, last, or in range, display
                if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
                {
                    //$this->return .= ($i == $this->current_page And $_POST['page'] != 'All') ? "<a title=\"Go to page $i of $this->num_pages\" class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"$_SERVER[PHP_SELF]?page=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";

                    $this->return .= ($i == $this->current_page And isset($_POST['page']) and $_POST['page'] != 'All') ? "<button style=\"opacity: 0.6; pointer-events: none; background-color: orange;\">$i</button>":"<button id=\"".$this->tbl."_btnPaging_$i\" onclick=\"pagingViewListLoad($i,'$this->items_per_page','$this->tbl');\">&nbsp;$i&nbsp;</button>";//tes
                }

                if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= "<button style=\"opacity: 0.6; pointer-events: none;\"> ... </button>";
            }

            //$this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_POST['page'] != 'All')) ? "<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?page=$next_page&ipp=$this->items_per_page$this->querystring\">Next &raquo;</a>\n":"<span class=\"inactive\" href=\"#\">&raquo; Next</span>\n";

            $this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And (isset($_POST['page']) != 'All')) ? "<button id=\"".$this->tbl."_btnPaging_next\" onclick=\"pagingViewListLoad($next_page,'$this->items_per_page','$this->tbl');\">&nbsp;Next &raquo;&nbsp;</button>\n":"<button style=\"opacity: 0.6; pointer-events: none;\">&raquo; Next</button>\n";

            //$this->return .= ($_POST['page'] == 'All') ? "<a class=\"current\" style=\"margin-left:10px\" href=\"#\">All</a> \n":"<a class=\"paginate\" style=\"margin-left:10px\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">All</a> \n";

            //$this->return .= ($_POST['page'] == 'All') ? "<a class=\"current\" style=\"margin-left:10px\" href=\"#\" >All</a> \n":"<button id=\"btnPaging_all\"  onclick=\"pagingViewListLoad(1,'All$this->querystring');\">&nbsp;All&nbsp;</button> \n";

            //===========================================================================

        }
        else
        {

            //============================================================================= paging

            for($i=1;$i<=$this->num_pages;$i++)
            {
                //$this->return .= ($i == $this->current_page) ? "<a class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?page=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";

                $this->return .= ($i == $this->current_page) ? "<button style=\"opacity: 0.6; pointer-events: none; background-color: orange;\">$i</button> ":"<button id=\"".$this->tbl."_btnPaging_$i\" onclick=\"pagingViewListLoad($i,'$this->items_per_page','$this->tbl');\">&nbsp;$i&nbsp;</button> ";

            }
            //$this->return .= "<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">All</a> \n";
            //$this->return .= "<button class=\"btnGen\" id=\"btnPaging_all\" onclick=\"pagingViewListLoad(1,'All$this->querystring');\" onmousedown=\"btnMouseD(this.id);\" onmouseout=\"btnMouseU(this.id);\" onmouseup=\"btnMouseU(this.id);\">&nbsp;All&nbsp;</button>  \n";

            //==============================================================================

        }
        //echo "IPP".$_POST['ipp'];
        $this->low = ($this->current_page-1) * $this->items_per_page;
        $this->high = (isset($_POST['ipp']) and $_POST['ipp'] == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;
        //echo "<br>$this->items_per_page<br>";
        $this->limit = (isset($_POST['ipp']) and $_POST['ipp'] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
        $this->posisi = ($this->current_page-1) * $this->items_per_page;
    }

    function display_items_per_page()
    {
        $items = '';
        $ipp_array = array(2,6,9,10,15,25,50,100); //'All'
        foreach($ipp_array as $ipp_opt)	$items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";
        //return "<span class=\"paginate\">Item per halaman:</span><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?page=1&ipp='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n";
        return "<span class=\"paginate\">Item per halaman : </span><select id=\"sel_item_".$this->tbl."\" onchange=\"pagingViewListLoad(1,this[this.selectedIndex].value,'$this->tbl');return false\">$items</select>\n";
    }

    function display_jump_menu()
    {
        $option = '';
        for($i=1;$i<=$this->num_pages;$i++)
        {
            $option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
        }
        //return "<span class=\"paginate\">Halaman:</span><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?page='+this[this.selectedIndex].value+'&ipp=$this->items_per_page$this->querystring';return false\">$option</select>\n";
        return "<span class=\"paginate\">Lompat ke halaman : </span><select id=\"sel".$this->tbl."\" onchange=\"pagingViewListLoad(this[this.selectedIndex].value,'$this->items_per_page','$this->tbl');return false\">$option</select>\n";
    }

    function display_pages()
    {
        return $this->return;
    }

}