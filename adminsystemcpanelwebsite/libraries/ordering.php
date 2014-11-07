<?php
class CI_ordering{
    function __construct(){
        $this->CI =& get_instance();
    }
    
    function move_up($id_nwc,$table)
    {// move a category one level up
        // get this one's properties
        $this_one = $this->get_cat_info($id_nwc);
        // get this id_nwc's weight
        $this_order = $this_one->Ordering;
        $this_pid   = $this_one->ParentID;
        // do nothing if this one is the first item
        if($this_order > 1){
            // get the first nearest lighter item
            $sql = "SELECT id, ordering FROM $table WHERE (ordering < '$this_order') AND ParentID = $this_pid ORDER BY Ordering DESC LIMIT 0,1";
            $replaced = $this->db->query($sql)->row();
            // switch their weights
            $swap_id = $replaced->CategoryID;
            $swap_order = $replaced->Ordering;
            $this->db->query("UPDATE category SET Ordering ='$swap_order' WHERE CategoryID='$id_nwc'");
            $this->db->query("UPDATE category SET Ordering ='$this_order' WHERE CategoryID='$swap_id'");

            return TRUE;
        }
        return FALSE;
    }
    function move_down($id_nwc)
    {// move a category one level down
        // get this one's properties
        $this_one = $this->get_cat_info($id_nwc);
        // get this id_nwc's weight
        $this_order = $this_one->Ordering;
        $this_pid   = $this_one->ParentID;
        // do nothing if this one is the last item
        $heaviest = $this->get_heaviest($this_pid);
        if($this_order <  $heaviest){
            // get the first heavier item
            $sql = "SELECT CategoryID, Ordering FROM category WHERE (Ordering > '$this_order') AND ParentID = $this_pid ORDER BY Ordering ASC LIMIT 0,1";
            $replaced = $this->db->query($sql)->row();
            // switch their weights
            $swap_id = $replaced->CategoryID;
            $swap_order = $replaced->Ordering;
            $this->db->query("UPDATE category SET Ordering ='$swap_order' WHERE CategoryID='$id_nwc'");
            $this->db->query("UPDATE category SET Ordering ='$this_order' WHERE CategoryID='$swap_id'");

            return TRUE;
        }
        return FALSE;
    }
    function get_cat_info($id_nwc)
    {// get a category info
        // input : $cat_id, single value
        // return : a row
            $search['CategoryID'] = $id_nwc;
            $rs = $this->db->getwhere("category", $search, 1);
            return $rs->num_rows() ? $rs->row() : false;
            // to be revised: what if $id_nwc is not existing?
    }
    function get_heaviest($nwc_pid)
    {// get heaviest item in a branch (nwc_pid)
        $sql = "SELECT MAX(ordering) AS ordering FROM category WHERE ParentID ='$nwc_pid'";
        return $this->db->query($sql)->first_row()->ordering;
    }    
              
}
