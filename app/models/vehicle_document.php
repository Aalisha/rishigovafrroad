<?php

/**
 * Document Upload model.
 *
 * 
 */
class VehicleDocument extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'VehicleDocument';

    /**
     * Model Database Configuration
     *
     * @var string
     * @access public
     */
    var $useDbConfig = 'default';

    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "PR_DT_UPLOAD_VEHICLE_DOCS_MDC";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'vc_upload_vehicle_id';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array(
        'vc_uploaded_doc_name' => array(
            'rule1' => array(
                'rule' => array('extension', array('pdf')),
                'required' => 'create',
                'allowEmpty' => true,
                'message' => 'Only .pdf file accepted',
                'on' => 'create',
                'last' => true
            ),
            'rule2' => array(
                'rule' => array('extension', array('pdf')),
                'message' => 'Only pdf file accepted',
                'on' => 'update',
            ),
            'size' => array(
                'rule' => 'checkSize',
                'message' => 'Could not be more than 0.5MB.'
            )
        )
    );

    /**
     *
     *
     */
    function checkSize($data) {

        if ($data['vc_uploaded_doc_name']['size'] <= 512000 && $data['vc_uploaded_doc_name']['size'] > 0) {

            return true;
        }

        return false;
    }

}