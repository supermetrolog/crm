<?php

class Request extends Post
{
    public function setTable()
    {
        return 'c_industry_requests';
    }

    public function getRequestDealType()
    {
        return $this->getField('deal_type');
    }

    public function getRequestDealTypeName()
    {
        $status = new Post($this->getRequestDealType());
        $status->getTable('l_deal_types');
        return $status->title();
    }

    public function getRequestStatusId()
    {
        return $this->getField('status');
    }

    public function getRequestStatus()
    {
        $status = new Post($this->getRequestStatusId());
        $status->getTable('l_statuses_all');
        return $status->title();
    }

    public function getRequestObjectTypeId()
    {
        return $this->getJsonField('object_type');
    }

    public function getRequestObjectType()
    {
        $object_type = new Post($this->getJsonField('object_type'));
        $object_type->getTable('l_object_types');
        return $object_type->title();
    }

    public function getRequestRegions()
    {
        return $this->getJsonField('regions');
    }

    public function getRequestDirections()
    {
        return $this->getJsonField('directions');
    }

    public function getRequestPurposes()
    {
        return $this->getJsonField('purposes');
    }
}