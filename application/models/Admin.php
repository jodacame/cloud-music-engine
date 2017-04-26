<?php
class Admin extends CI_Model 
{
    function __construct()
    {    
        parent::__construct();
    }    

    function getTable($table,$where = false,$order = false,$select = false,$offset = false,$limit = false,$like = false,$distinct = false)    
    {
      
        if($limit !== FALSE)
        {            
            if($offset)
                $this->db->limit($offset,$limit);
            else
                $this->db->limit($limit);
        }
        if($distinct != FALSE)
            $this->db->distinct();
        if($select)
            $this->db->select($select);
        if($order)
            $this->db->order_by($order);
        if($like)
        {
            foreach ($like as $key => $value) {
                $this->db->or_like($key,$value);
            }    
        }
        

        //if($where && is_array($where))   
        if($where)   
            return $this->db->get_where($table,$where);        
        return $this->db->get($table);        
    }



    function getCountTable($table,$where = false)
    {
        if($where)
        {
            $obj = $this->db->get_where($table,$where); 
            return $obj->num_rows();   
        }
        return $this->db->count_all($table);
    }

    


    function setTable($table,$data,$batch=false)
    {
        if($batch)
        {
            if(count($data) == 0)
                return false;
            foreach ($data[0] as $key => $value) {
                $fields .= $key.",";
            }
            $fields = substr($fields, 0,-1);
            foreach ($data as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    $value[$key2] = $this->db->escape_str($value2);
                    //$value[$key2] = str_ireplace("\'","''",$value[$key2]);
                }
                $values .= "('".implode("','", $value)."'),";
            }

            $query = "INSERT IGNORE INTO  {PRE}$table ($fields) VALUES $values";
            
             $query = substr( $query, 0,-1);
            return $this->db->query($query);
        }
        if($this->db->insert($table, $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function setTableIgnore($table,$data)
    {
        $insert_query = $this->db->insert_string($table, $data);
        $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
        if($this->db->query($insert_query))
            return $this->db->insert_id();
        else
            return false;
    }

    function updateTable($table,$data,$where)
    {
        return $this->db->update($table, $data, $where);
    }


   

    function deleteTable($table,$where)
    {
        return $this->db->delete($table,$where); 
    }

    function getRegisteredUsersByMonth()
    {
        return $this->db->query("SELECT count(*) as n,SUBSTRING(registered,1,7) as month FROM `{PRE}users` GROUP BY SUBSTRING( registered, 1, 7 ) order by SUBSTRING(registered,1,7) desc limit 12 ");
    }

   
   /* Sitemap */

    function sitemap_get_artist($offset = false)
    {
        if($offset !== false)
            return $this->db->query("SELECT artist FROM {PRE}artist group by artist ORDER BY artist LIMIT 5000 OFFSET ".intval($offset));
        return $this->db->query("SELECT artist FROM {PRE}artist group by artist");
    }

    function sitemap_get_tracks($offset = false)
    {
        if($offset !== false)
            return $this->db->query("SELECT artist,track,album,updated FROM {PRE}tracks  group by artist,track,album,updated ORDER BY artist,album,track  LIMIT 5000 OFFSET ".intval($offset));
        return $this->db->query("SELECT artist,album,track  FROM {PRE}tracks  group by artist,track ");
    }

    function sitemap_get_users()
    {
        return $this->db->query("SELECT username  FROM {PRE}users order by username");
    }    
    
    function sitemap_get_stations()
    {
        return $this->db->query("SELECT *  FROM {PRE}stations order by  idstation");
    }

    function sitemap_get_playlist()
    {
        return $this->db->query("SELECT *  FROM {PRE}playlists order by  idplaylist");
    }


}
