<?php

/**
 * 
 * Client Upload Docs
 * 
 */
class ClientUploadDocs extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'ClientUploadDocs';

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
    var $useTable = 'DT_CLIENT_UPLOAD_DOCS_FLR';

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'vc_upload_id';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array(
        'fuelusagedoc' => array(
            'extension' => array(
                'rule' => array('extension', array('jpg', 'jpeg', 'pdf', 'png')),
                'message' => 'You must select a valid file eg. jpg,jpeg,pdf,png'
            ),
            'size' => array(
                'rule' => 'checkSize',
                'message' => 'Could not be more than 2MB.'
            ),
            'required' => array(
                'required' => true,
                'message' => 'Required'
            )
        ),
        'bankdoc' => array(
            'extension' => array(
                'rule' => array('extension', array('jpg', 'jpeg', 'pdf', 'png')),
                'message' => 'You must select a valid file eg. jpg,jpeg,pdf,png'
            ),
            'size' => array(
                'rule' => 'checkSize',
                'message' => 'Could not be more than 2MB.'
            ),
            'required' => array(
                'required' => true,
                'message' => 'Required'
            )
        ),
        'ownershipchange' => array(
            'extension' => array(
                'rule' => array('extension', array('jpg', 'jpeg', 'pdf', 'png')),
                'message' => 'You must select a valid file eg. jpg,jpeg,pdf,png'
            ),
            'size' => array(
                'rule' => 'checkSize',
                'message' => 'Could not be more than 2MB.'
            ),
            'required' => array(
                'required' => true,
                'message' => 'Required'
            )
        ),
        /*
        'complaint_doc' => array(
            'extension' => array(
                'rule' => array('extension', array('jpg', 'jpeg', 'pdf', 'png')),
                'message' => 'You must select a valid file eg. jpg,jpeg,pdf,png'
            ),
            'size' => array(
                'rule' => 'checkSize',
                'message' => 'Could not be more than 2MB.'
            ),
            'required' => array(
                'required' => false,
                'message' => 'Required'
            )
        )
        */
        
    );

    /**
     *
     * Function to generate primary key
     *
     */
    function getPrimaryKey() {

        $count = $this->find('count');

        $primaryKey = $count + 1;

        if ($this->find('count', array('conditions' => array($this->name . '.' . $this->primaryKey => $primaryKey))) > 0) {

            $i = (int) $count;

            while ($i >= 1) {

                $i += 1;

                $primaryKey = $i;

                $returnValue = $this->find('count', array('conditions' => array($this->name . '.' . $this->primaryKey => $primaryKey)));

                if ($returnValue == 0) {

                    break;
                }

                $i++;
            }

            return $primaryKey;
        } else {

            return $primaryKey;
        }
    }

    /**
     *
     *
     * Custom function for maximum file size validation
     *
     */
    function checkSize($file) {

        $fileObject = @current($file);

        if ((int)@$fileObject['size'] <= 2048000 && (int) @$fileObject['size'] > 0) {

            return true;
        }

        return false;
    }

}