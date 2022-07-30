<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Utils_model extends CI_Model
{
    /* Untuk memasukan data ke database */
    public function insert($table_name, $data_insert)
    {
        $data_insert['id'] = uniqid();
        $data_insert['created_at'] = date('Y-m-d H:i:s');
        $data_insert['updated_at'] = date('Y-m-d H:i:s');
        $result = $this->db->insert($table_name, $data_insert);
        return $result;
    }

    /* Untuk memasukan data ke database (dengan id autoincrement) */
    public function insert_autoincrement_id($table_name, $data_insert)
    {
        $data_insert['created_at'] = date('Y-m-d H:i:s');
        $data_insert['updated_at'] = date('Y-m-d H:i:s');
        $result = $this->db->insert($table_name, $data_insert);
        return $result;
    }

    /* Untuk delete */
    public function delete($table_name, $data_where)
    {
        $result = $this->db->delete($table_name, $data_where);
        return $result;
    }
    
    /* Untuk menupdate data ke database */
    public function update($table_name, $data_where, $data_update)
    {
        $this->db->where($data_where);
				$data_update['updated_at'] = date('Y-m-d H:i:s');
        $result = $this->db->update($table_name, $data_update);

        return $result;
    }
    
    /* Untuk mengambil data edits */
    public function getEdit($table_name, $arr_where = null, $select = null) 
    {
        if (!is_null($select)) {
            $this->db->select($select);
        }
        if (!is_null($arr_where)) {
            $this->db->where($arr_where);
        }
        $row = $this->db->get($table_name);

        return $row->row_array();
    }

    /* Insert untuk master detail, return last id */
    public function insert_masdet($table_name, $data_insert)
    {
        $id = uniqid();
        $data_insert['id'] = $id;
        $data_insert['created_at'] = date('Y-m-d H:i:s');
        $data_insert['updated_at'] = date('Y-m-d H:i:s');
        $result = $this->db->insert($table_name, $data_insert);

        return $id;
    }

    /* Untuk menampilkan list data */
    public function listData($table_name, $arr_where = null, $select = null, $extra_query = array())
    {
        $query = $this->db;
        if (isset($select)) {
            $query->select($select);
        }
        $query->from($table_name);
        if ($arr_where!=null)
            $query->where($arr_where);

        // extra query
        if (count($extra_query) > 0) {
            if (isset($extra_query['order_by'])) {
                $query->order_by($extra_query['order_by']);
            }
        }

        return $query->get()->result_array();
    }

    /** Untuk menampilkan data dan detailnya */
    public function listDataDetail($data)
    {
        $query = $this->db;
        if (isset($data['select'])) {
            $query->select($data['select']);
        }
        $query->from($data['table']);
        $query->where($data['table_where']);
        $query->join($data['table_detail'], $data['on_table'] .' = ' . $data['on_table_detail'], 'left');

        if (isset($data['order_by'])) {
            $order_by_desc_asc = isset($data['order_by_asc_desc']) ? $data['order_by_asc_desc'] : 'asc';
            $query->order_by($data['order_by'], $order_by_desc_asc);
        }

        if (isset($data['limit'])) {
            $query->limit($data['limit']);
        }

        if (isset($data['group_by'])) {
            $query->group_by($data['group_by']);
        }

        return $query->get()->result_array();
    }

    /** Untuk menghitung jumlah data pada table */
    public function count_table($table_name)
    {
        $query = $this->db->count_all_results($table_name);
        return $query;
    }

    public function list_data_for_select($table_name, $arr_where = null)
    {
        $this->db->select('id, name');
        $this->db->from($table_name);
        if ($arr_where != null)
            $this->db->where($arr_where);
        return $this->db->get()->result_array();
    }

    public function get_last_value($table_name, $field_name, $order_by = 'desc', $arr_where = null, $order_by_field = null)
    {
        $this->db->select($field_name)
            ->from($table_name)
            ->limit(1);

        if ($order_by_field != null) {
            $this->db->order_by($order_by_field, $order_by);
        } else {
            $this->db->order_by($field_name, $order_by);
        }

        if ($arr_where != null) {
            $this->db->where($arr_where);
        }

        $result = $this->db->get()->result()[0]->$field_name ?? 0;

        return $result;
    }
}
/* End of file Utils_model.php */
 ?>
