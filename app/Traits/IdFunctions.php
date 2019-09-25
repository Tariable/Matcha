<?php


namespace App\Traits;


trait IdFunctions
{
    /**
     * Push 'id' to data array.
     *
     * @param array $data
     * @param integer $id
     * @return array
     */
    public function addIdToData($data, $id){
        $data['id'] = $id;
        return $data;
    }

    /**
     * Add to data 'id' and create new row in database;
     *
     * @param array $data
     * @param integer $id
     * @return void
     */
    public function saveWithId($data, $id){

        $data = $this->addIdToData($data, $id);
        $this->create($data);
    }

    /**
     * Get row by id from database;
     *
     * @param integer $id
     * @return object
     */
    public function getById($id)
    {
        return $this->whereId($id)->first();
    }

    /**
     * Add to data 'id' and update row in database;
     *
     * @param array $data
     * @param integer $id
     * @return void
     */
    public function updateWithId($data, $id){
        $data = $this->addIdToData($data, $id);
        $this->whereId($id)->first()->update($data);
    }

}
