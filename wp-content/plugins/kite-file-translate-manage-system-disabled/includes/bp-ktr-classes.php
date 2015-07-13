<?php

/**
 * This function should include all classes and functions that access the database.
 * In most BuddyPress components the database access classes are treated like a model,
 * where each table has a class that can be used to create an object populated with a row
 * from the corresponding database table.
 * 
 * By doing this you can easily save, update and delete records using the class, you're also
 * abstracting database access.
 */

class BP_Ktr_TableName {
	var $id;
	var $user_type;
	var $user_id;
	var $date_uploaded;
	var $title;
	var $description;
	var $privacy;
	var $pic_org_url;
	var $pic_org_path;

	
	/**
	 * bp_ktr_tablename()
	 *
	 * This is the constructor, it is auto run when the class is instantiated.
	 * It will either create a new empty object if no ID is set, or fill the object
	 * with a row from the table if an ID is provided.
	 */

         function bp_ktr_tablename( $id = null ) {
		$this->__construct( $id );
	}

	function __construct( $id = null ) {
		global $wpdb, $bp;

		if ( $id ) {
			$this->populate( $id );
		}
	}


      
	
	/**
	 * populate()
	 *
	 * This method will populate the object with a row from the database, based on the
	 * ID passed to the constructor.
	 */
	function populate() {
		global $wpdb, $bp, $creds;
		
			global $wpdb,$bp;

		 $sql = $wpdb->prepare( "SELECT * FROM {$bp->ktr->table_name} WHERE id = %d", $id );
		$picture = $wpdb->get_row( $sql );

		if ( $picture ) {
                $this->user_type = $picture->user_type;
                $this->user_id = $picture->user_id;
                $this->id = $picture->id;
	        $this->date_uploaded = $picture->date_uploaded;
	        $this->title = $picture->title;
	        $this->description = $picture->description;
	        $this->privacy = $picture->privacy;
	        $this->pic_org_path = $picture->pic_org_path;
	        $this->pic_org_url = $picture->pic_org_url;

		}
	}
	
	/**
	 * save()
	 *
	 * This method will save an object to the database. It will dynamically switch between
	 * INSERT and UPDATE depending on whether or not the object already exists in the database.
	 */
	
	function save() {
		global $wpdb, $bp;
		
		/***
		 * In this save() method, you should add pre-save filters to all the values you are saving to the
		 * database. This helps with two things -
		 * 
		 * 1. Blanket filtering of values by plugins (for ktr if a plugin wanted to force a specific 
		 *	  value for all saves)
		 * 
		 * 2. Security - attaching a wp_filter_kses() call to all filters, so you are not saving
		 *	  potentially dangerous values to the database.
		 *
		 * It's very important that for number 2 above, you add a call like this for each filter to
		 * 'bp-ktr-filters.php'
		 *
		 *   add_filter( 'ktr_data_fieldname1_before_save', 'wp_filter_kses' );
		 */	
		
		//$this->fieldname1 = apply_filters( 'bp_ktr_data_fieldname1_before_save', $this->fieldname1, $this->id );
		//$this->fieldname2 = apply_filters( 'bp_ktr_data_fieldname2_before_save', $this->fieldname2, $this->id );
		
		/* Call a before save action here */
		do_action( 'bp_ktr_data_before_save', $this );
						
		if ( $this->id ) {
			// Update
			$sql = $wpdb->prepare(
				"UPDATE {$bp->ktr->table_name} SET
					user_type = %s,
					user_id = %d,
					date_uploaded = %s,
					title = %s,
					description = %s,
					privacy = %d,
					pic_org_url = %s,
					pic_org_path =%s

				WHERE id = %d",
					$this->user_type,
					$this->user_id,
					$this->date_uploaded,
					$this->title,
					$this->description,
					$this->privacy,
					$this->pic_org_url,
					$this->pic_org_path

				);
		} else {
		// $this->description='';
			$sql = $wpdb->prepare(
					"INSERT INTO {$bp->ktr->table_name} (
						user_type,
						user_id,
						date_uploaded,
						title,
						description,
						privacy,
						pic_org_url,
						pic_org_path
					) VALUES (
						%s, %d, %s, %s, %s, %d, %s, %s
					)",
						$this->user_type,
						$this->user_id,
						$this->date_uploaded,
						$this->title,
						$this->description,
						$this->privacy,
						$this->pic_org_url,
						$this->pic_org_path
					);
		}


                $result = $wpdb->query( $sql );
				
		if ( !$result )
			return false;
		
		if ( !$this->id ) {
			$this->id = $wpdb->insert_id;
		}	
		
		/* Add an after save action here */
		//do_action( 'bp_ktr_data_after_save', $this );
		
		return $result;
	}

	/**
	 * delete()
	 *
	 * This method will delete the corresponding row for an object from the database.
	 */	
	function delete() {
		global $wpdb, $bp;
		
		return $wpdb->query( $wpdb->prepare( "DELETE FROM {$bp->ktr->table_name} WHERE id = %d", $this->id ) );
               
	}

	/* Static Functions */

	/**
	 * Static functions can be used to bulk delete items in a table, or do something that
	 * doesn't necessarily warrant the instantiation of the class.
	 *
	 * Look at bp-core-classes.php for ktrs of mass delete.
	 */

	function delete_all() {

	}




    public static function query_pictures($args = '',$count=false,$adjacent=false) {

		global $bp, $wpdb;

		
            
		$r = wp_parse_args( $args, $defaults );
		extract( $r , EXTR_SKIP);
//                echo "<pre>";
//                var_dump($args);
//                echo "</pre>";
		$where = "1 = 1";

		if ($user_id){
			$where .= $wpdb->prepare(' AND user_id = %d',$user_id);
		}
		if ($id && $adjacent != 'next' && $adjacent != 'prev' && !$count){
			$where .= $wpdb->prepare(' AND id = %d',$id);
		}

		switch ( $privacy ) {
			case 'public':
			case 0 === $privacy:
			case '0':
				$where .= " AND privacy = 0";
				break;

			case 'members':
			case 2:
				if (bp_album_privacy_level_permitted()>=2 || $priv_override)
					$where .= " AND privacy = 2";
				else
					return $count ? 0 : array();
				break;

			case 'friends':
			case 4:
				if (bp_album_privacy_level_permitted()>=4 || $priv_override)
					$where .= " AND privacy = 4";
				else
					return $count ? 0 : array();
				break;

			case 'private':
			case 6:
				if (bp_album_privacy_level_permitted()>=6 || $priv_override)
					$where .= " AND privacy = 6";
				else
					return $count ? 0 : array();
				break;

			case 'admin':
			case 10:
				if (bp_album_privacy_level_permitted()>=10 || $priv_override)
					$where .= " AND privacy = 10";
				else
					return $count ? 0 : array();
				break;

			case 'all':
				if ( $priv_override )
					break;

			case 'permitted':
			default:
				$where .= " AND privacy <= ".bp_album_privacy_level_permitted();
				break;
		}
		if(!$count){
		$order = "";
		$limits = "";
			if($adjacent == 'next'){
				$where .= $wpdb->prepare(' AND id > %d',$id);
				$order = "ORDER BY id ASC";
				$limits = "LIMIT 0, 1";
			}elseif($adjacent == 'prev'){
				$where .= $wpdb->prepare(' AND id < %d',$id);
				$order = "ORDER BY id DESC";
				$limits = "LIMIT 0, 1";
			}elseif(!$id){

				if ($orderkey != 'id' && $orderkey != 'user_id' && $orderkey != 'status' && $orderkey != 'random') {
				    $orderkey = 'id';
				}

				if ($ordersort != 'ASC' && $ordersort != 'DESC') {
				    $ordersort = 'DESC';
				}

				if($orderkey == 'random'){
				    $order = "ORDER BY RAND() $ordersort";
				}
				else {
				    $order = "ORDER BY $orderkey $ordersort";
				}

				if ($per_page){
					if ( empty($offset) ) {
						$limits = $wpdb->prepare('LIMIT %d, %d', ($page-1)*$per_page , $per_page);
					} else { // we're ignoring $page and using 'offset'
						$limits = $wpdb->prepare('LIMIT %d, %d', $offset , $per_page);
					}
				}
			}

			$sql = $wpdb->prepare( "SELECT * FROM {$bp->ktr->table_name} WHERE $where $order $limits") ;
			$result = $wpdb->get_results( $sql );

		} else {
			$select='';
			$group='';
			if ($groupby=='privacy'){
				$select='privacy,';
				$group='GROUP BY privacy';
			}

			$sql =  $wpdb->prepare( "SELECT DISTINCT $select COUNT(id) AS count FROM {$bp->ktr->table_name} WHERE $where $group") ;
			if ($group)
				$result = $wpdb->get_results( $sql );
			else
				$result = $wpdb->get_var( $sql );
		}

		return $result;
	}

	public static function delete_by_user($user_id,$user_type ) {

		global $bp, $wpdb;

		return $wpdb->query( $wpdb->prepare( "DELETE FROM {$bp->album->table_name} WHERE user_type = %d AND user_id = %d ", $user_type, $user_id ) );
	}

	public static function delete_by_user_id($user_id) {
		return BP_Album_Picture::delete_by_user($user_id,'user');
	}

}




?>