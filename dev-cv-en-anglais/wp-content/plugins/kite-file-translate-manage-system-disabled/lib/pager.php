<?php
class Pager {
    protected $table;
    protected $pages;
    protected $item;
    protected $perpage;
    protected $page;
    protected $wpdb;
    protected $otherSQL;

    public function __construct($table, $perpage, $page, $otherSQL = '') {
        global $wpdb;
         $client_info_table_name = $wpdb->prefix . "kiteorder_client";
         $domain_info_table_name = $wpdb->prefix . "kiteorder_order";
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix . $table;
        $this->perpage = $perpage;
        $approve_table=$wpdb->prefix;
      $this->data_per_page = 10;
      if($_REQUEST['pagenum']&&$_REQUEST['pagenum']!=1){
         $this->data_per_page = 10;
          $start=(($_REQUEST['pagenum']-1)*$this->data_per_page);
      }else{
          $start=1;
          $this->data_per_page = 10;
      }



                $item_total=$wpdb->get_results($wpdb->prepare( "SELECT
                *,
                (SELECT count(r_id)
                FROM
                ".$domain_info_table_name." AS d
                Inner Join ".$client_info_table_name." AS c ON d.r_client = c.c_id ORDER BY
                d.r_id DESC)as total
                FROM
                ".$domain_info_table_name." AS d
                Inner Join ".$client_info_table_name." AS c ON d.r_client = c.c_id ORDER BY
                d.r_id DESC LIMIT $start , $this->data_per_page",  ''));


         foreach ( $item_total as $t ) {
               
             $this->item=ceil($t->total) ;
         }

        $this->page = $page;
       // $this->item = ceil($wpdb->get_var('SELECT COUNT(*) FROM ' . $this->table));
        $this->pages = ceil($this->item / $this->perpage);
       global $pages;
        $pages=$this->pages;
        $this->otherSQL = $otherSQL;
       
    }

    protected function getFirstPageURL() {
        return UrlUtils::appendQueryString('pagenum', 1);
    }

    protected function getPrevPageURL() {
        
        return UrlUtils::appendQueryString('pagenum', $this->page == 1 ? 1 : $this->page - 1);
    }

    protected function getNextPageURL() {
        return UrlUtils::appendQueryString('pagenum', $this->page == $this->pages ? $this->pages : $this->page + 1);
    }

    protected function getLastPageURL() {
        return UrlUtils::appendQueryString('pagenum', $this->pages);
    }

    protected function getPageURL($page) {
        return UrlUtils::appendQueryString('pagenum', $page);
    }

    public function generatePagination($range = 2,$class='') {
        $shown = $range * 2 + 1;
        if($class){
           $class=$class;
        }else{
            $class='';//'tablenav';
        }
        ?>

        <div class="<?php echo $class?>">
            <div class="tablenav-pages">
                <span class="displaying-num"><?php echo $this->item;$item=$this->item; if($item >1){echo " items";}else{echo " item";}?></span>
                <a href="<?php echo $this->getFirstPageURL(); ?>" <?php if ($this->page == 1) echo 'class="disabled"';  ?>>&laquo;</a>
                <a href="<?php echo $this->getPrevPageURL(); ?>" <?php if ($this->page == 1) echo 'class="disabled"';  ?>>&lsaquo;</a>


   


               <span class="paging-input">

                   
                <input type="hidden" name="page" value="kite_oerder_menu" />
               <?php  if ($_REQUEST['pagenum'])
                {
                    
                    if($_REQUEST['pagenum']>$this->pages)
                    {
                        global $pages;
                      echo $pages= $this->pages;
                    }else{
                        global $pages;
                        $pages= $_REQUEST['pagenum'];
                    }
                }else{
                    global $pages;
                    $pages= "1";}?>
                <input class="current-page" type="text" title="Current page" name="pagenum" value="<?php global $pages; echo $pages; ?>" size="1" />
                
                 
               
                of
                <span class="total-pages"><?php echo $this->pages;?></span>

                </span>
                <a href="<?php echo $this->getNextPageURL(); ?>" <?php if ($this->page == $this->pages) echo 'class="disabled"';  ?>>&rsaquo;</a>
                <a href="<?php echo $this->getLastPageURL(); ?>" <?php if ($this->page == $this->pages) echo 'class="disabled"';  ?>>&raquo;</a>
            </div>
        </div>
    
        <?php
    }

    public function getPageData() {
        $data = $this->wpdb->get_results('SELECT * FROM ' . $this->table . ' ' . $this->otherSQL . ' LIMIT ' . ($this->page - 1) * $this->perpage . ', ' . $this->perpage, OBJECT );
        return $data;
    }

}

class UrlUtils {

    public static function parseQueryString($url = '') {
        $queryArr = array();
        $queryStr = $_SERVER['QUERY_STRING'];
        if (!empty($url)) {
            $queryStr = parse_url($url, PHP_URL_QUERY);
        }
        parse_str($queryStr, $queryArr);
        return $queryArr;
    }

    public static function appendQueryString($key, $val, $url = "") {
        $queryArr = self::parseQueryString($url);
        $queryArr[$key] = $val;
        $queryStr = http_build_query($queryArr);

        $url = empty($url) ? $_SERVER['PHP_SELF'] : $url;
        $parts = parse_url($url);
        $parts['query'] = $queryStr;

        return $parts['path'] . '?' . $parts['query'];
    }

    public static function removeQueryString($remove) {
        $queryArr = self::parseQueryString();
        if (is_array($remove)) {
            foreach ($remove as  $r) {
                if (array_key_exists($r, $queryArr)) {
                    unset($queryArr[$r]);
                }
            }
        } else {
            if (array_key_exists($remove, $queryArr)) {
                unset($queryArr[$remove]);
            }
        }

        $queryStr = http_build_query($queryArr);
        return $_SERVER['PHP_SELF'] . '?' . $queryStr;
    }

}
?>