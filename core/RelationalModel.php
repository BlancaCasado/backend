<?php
require_once __DIR__.'/Model.php';

class RelationalModel extends Model
{
    public $table = null;  // tabla relacional
    public $table1 = null; //tabla relacion 1
    public $field1 = null; //camplo relacion 1
    public $table2 = null; //tabla relacion 2
    public $field2 = null; //camplo relacion 2
	function __construct()
	{
        parent::__construct();
    }
    
    /*
     * Function get
     * Devuelve la relacion
     * @params $fiel1 (int id tabla 1)
     *         $fiel2 (int id tabla 2)
     *         $join1 (bolean o string de los campos del select join tabla 1)
     *         $join2 (bolean o string de los campos del select join tabla 2)
     * 
     */
    public function get($id1 = null, $id2 = null , $join1 = null, $join2 = null)
    {
        // $sql = "SELECT $this->*
        //         FROM $this->table
        //         INNER JOIN $this->table1 ON $this->table1.id = $this->table.$this->fiel1
        //         INNER JOIN $this->table2 ON $this->table2.id = $this->table.$this->fiel2
        //         WHERE
        //             $this->table.$this->field1 = :id1
        //         AND
        //             $this->table.$this->field2 = :id2";
        if ($id1 == null && $id2 == null) {
            $this->error('Err:Relational all fields null', 500);
        }
        
        // AÑADIMOS LOS SELECT A LAS CONSULTAS
        $select = $this->getSelects($join1, $join2);
        $from = " FROM $this->table ";
        $join = $this->getJoins($join1, $join2);
        $whereC = $this->getWhere($id1, $id2);
        $where = $whereC[0];
        $params = $whereC[1];

        $sql = $select.$from.$join.$where;
        return $this->query($sql,$params);
    }

    public function create($id1, $id2)
    {
        $sql = "INSERT INTO
                    $this->table
                    ($this->field1, $this->field2)
                VALUES 
                    (:id1, :id2)";
        $params = [
            [':id1', $id1, PDO::PARAM_INT],
            [':id2', $id2, PDO::PARAM_INT]
        ];
        return $this->query($sql,$params);
    }

    public function createMany($array)
    {
        try {
            foreach ($array as $insert) {
                $this->create($insert[0], $insert[1]);
            }
        } catch (\Throwable $th) {
            if (MOD_DESARROLLO) {
                throw $th;
            } else {
                $this->error('Error del servidor', 500);
            }
        }
    }
    public function delete($id1 = NULL, $id2 = NULL)
    {
        if ($id1 == null && $id2 == null) {
            $this->error('Err:Relational all fields null', 500);
        }
        $whereC = $this->getWhere($id1, $id2);
        $where = $whereC[0];
        $params = $whereC[1];
        $sql = "DELETE FROM $this->table $where";
        return $this->query($sql,$params);
    }

    private function getSelects($join1 = null, $join2 = null)
    {
        // AÑADIMOS LOS SELECT A LAS CONSULTAS devuelve array de selects por tablas
        $select = ["$this->table.*"];
        if ($join1) {
            if (is_string($join1)){
                $selects1 = split(',', $join1);
                $selects1A = [];
                foreach ($selects1 as $select) {
                    $selects1A[] = "$this->table1.$select";
                }
                $select[] = implode(',', $selects1A);
            } else {
                $select[] = "$this->table1.*";
            }
        }
        if ($join2) {
            if (is_string($join2)){
                $selects2 = split(',', $join2);
                $selects2A = [];
                foreach ($selects2 as $select) {
                    $selects2A[] = "$this->table2.$select";
                }
                $select[] = implode(',', $selects2A);
            } else {
                $select[] = "$this->table2.*";
            }
        }
        return "SELECT ".implode(',', $select)." ";
    }

    private function getJoins($join1 = null, $join2 = null)
    {
        $joins = [];
        if ($join1) {
            $joins[] = " INNER JOIN $this->table1 ON $this->table1.id = $this->table.$this->field1 ";
        }
        if ($join2) {
            $joins[] = " INNER JOIN $this->table2 ON $this->table2.id = $this->table.$this->field2 ";
        }
        return implode(' ', $joins);
    }

    private function getWhere($id1 = null, $id2 = null)
    {
        $where = [];
        $params = [];
        if ($id1) {
            $where[] = " $this->table.$this->field1 = :id1";
            $params[] = [':id1', $id1, PDO::PARAM_INT];
        }
        if ($id2) {
            $where[] = " $this->table.$this->field2 = :id2";
            $params[] = [':id2', $id2, PDO::PARAM_INT];
        }
        return [" WHERE ".implode(' AND ', $where), $params];
    }
}