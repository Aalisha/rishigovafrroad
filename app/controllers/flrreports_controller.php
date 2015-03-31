<?php

App::import('Sanitize');

/**
 *
 *
 */
class FlrreportsController extends AppController {

    /**
     *
     *
     */
    var $name = 'Flrreports';

    /**
     *
     *
     */
    var $components = array('Session', 'Auth', 'RequestHandler', 'Email', 'Flrreportpdfcreator');

    /**
     *
     *
     */
    var $uses = array();

    /**
     *
     *
     */
    public function beforeFilter() {

        parent::beforeFilter();

        $currentUser = $this->checkUser();

        $this->layout = $this->Auth->params['prefix'] . '_layout';


        $vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');
        $ch_active = $this->Session->read('Auth.Client.ch_active_flag');
        //$vc_cbc_customer_no = $this->Session->read('Auth.Member.vc_cbc_customer_no');
        $vc_username = $this->Session->read('Auth.Member.vc_username');
        $FRL_USER_TYPE = $this->Session->read('Auth.Member.vc_user_login_type');



        if ($vc_username != '' && $ch_active == 'STSTY04' && $FRL_USER_TYPE == 'USRLOGIN_CLT')
            $this->Auth->allow('*');

        $this->loginRightCheck();
    }

    function loginRightCheck() {
        //pr($this->Auth->allowedActions);
        if ($this->loggedIn && !in_array(strtolower($this->action), $this->Auth->allowedActions)) {
            $this->redirect(array('controller' => 'members', 'action' => 'login', @$this->Auth->params['prefix'] => false));
        }
    }

    /**
     * 
     * Claim Details
     * 
     */
    public function flr_claimdetails() {
        //$this->ClaimDetail->recursive = -1;
        //	
        try {
            $this->loadModel('ClaimHeader');
            $this->loadModel('ClaimDetail');
            $this->loadModel('ClaimprocessData');
            //unset($this->ClaimDetail->belongsTo);
            $vc_client_no = $this->Session->read('Auth.Client.vc_client_no');

            $this->ClaimDetail->unbindModel(
                    array('belongsTo' => array('ClaimHeader'))
            );
            $fields = array('ClaimHeader.vc_comp_code', 'ClaimHeader.vc_claim_no', 'ClaimHeader.vc_client_no', 'ClaimHeader.vc_party_claim_no', 'ClaimHeader.vc_payment_status', 'ClaimHeader.nu_payment_amount', 'ClaimHeader.ch_email_flag',
                'ClaimHeader.vc_status', 'ClaimDetail.vc_client_no', 'ClaimDetail.vc_invoice_no',
                'ClaimDetail.dt_invoice_date', 'ClaimHeader.dt_entry_date', 'ClaimDetail.nu_litres',
                'ClaimDetail.nu_refund_rate', 'ClaimDetail.vc_status', 'ClaimDetail.nu_amount',
                'ClaimDetail.vc_outlet_code', 'ClaimDetail.vc_reasons',);


            if (isset($this->params['named']['fromDate'])):
                $fromDate = date('Y-M-d', strtotime($this->params['named']['fromDate']));
            else :
                $fromDate = (isset($this->data['Claimdetailsreport']['fromDate']) &&
                        !empty($this->data['Claimdetailsreport']['fromDate'])) ?
                        date('Y-M-d', strtotime($this->data['Claimdetailsreport']['fromDate'])) :
                        '';
            endif;

            if (isset($this->params['named']['toDate'])) :
                $toDate = date('Y-M-d 23:59:59', strtotime($this->params['named']['toDate']));

            else :
                $toDate = (isset($this->data['Claimdetailsreport']['toDate']) &&
                        !empty($this->data['Claimdetailsreport']['toDate'])) ?
                        date('Y-M-d 23:59:59', strtotime($this->data['Claimdetailsreport']['toDate'])) :
                        '';
            endif;

            if (isset($this->named['Claimdetailsreport']['dt_entry_date'])) :
                $calaim_date = date('Y-M-d', strtotime($this->named['Claimdetailsreport']['dt_entry_date']));

            else :
                $calaim_date = (isset($this->data['Claimdetailsreport']['dt_entry_date']) &&
                        !empty($this->data['Claimdetailsreport']['dt_entry_date'])) ?
                        date('Y-M-d', strtotime($this->data['Claimdetailsreport']['dt_entry_date'])) :
                        '';

            endif;

            if (isset($this->named['Claimdetailsreport']['vc_status'])) :
                $claim_status = $this->named['Claimdetailsreport']['vc_status'];

            else :
                $claim_status = (isset($this->data['Claimdetailsreport']['vc_status']) &&
                        !empty($this->data['Claimdetailsreport']['vc_status'])) ?
                        $this->data['Claimdetailsreport']['vc_status'] :
                        '';
            endif;


            if (isset($this->named['Claimdetailsreport']['vc_claim_no'])) :
                $claimNo = $this->named['Claimdetailsreport']['vc_claim_no'];


            else :
                $claimNo = (isset($this->data['Claimdetailsreport']['vc_claim_no']) &&
                        !empty($this->data['Claimdetailsreport']['vc_claim_no'])) ?
                        $this->data['Claimdetailsreport']['vc_claim_no'] :
                        '';
            endif;

            $conditions = array();
            if ($fromDate):

                $conditions+= array(
                    'ClaimHeader.dt_entry_date >=' => $fromDate,
                );

            endif;

            if ($toDate):

                $conditions+= array(
                    'ClaimHeader.dt_entry_date <=' => $toDate,
                );

            endif;

            if ($claimNo):

                $conditions+= array(
                    'ClaimDetail.vc_claim_no' => $claimNo);

            endif;

            $limit = 10;

            $conditions += array(
                'NOT' => array('ClaimHeader.vc_status' => 'STSTY08'),
                array('ClaimHeader.vc_claim_no = ClaimDetail.vc_claim_no'),
                array('ClaimHeader.vc_client_no' => $vc_client_no)
            );
            $options['joins'] = array(
                array('table' => 'HD_CLAIM_FLR',
                    'alias' => 'ClaimHeader',
                    'type' => 'INNER',
                    'conditions' => $conditions));


            $options['fields'] = $fields;


            $this->paginate = array(
                'joins' => $options['joins'],
                'fields' => $options['fields'],
                'order' => array('ClaimDetail.vc_claim_no' => 'desc',
                    'ClaimDetail.dt_invoice_date' => 'desc'),
                'limit' => $limit,
                'recursive' => -1
            );

            $pagecounter = (isset($this->params['named']['page']) && $this->params['named']['page'] > 1) ? $this->params['named']['page'] : 1;

            $claimNumber = array(
                $this->ClaimHeader->find('list', array('conditions' => array(
                        'ClaimHeader.vc_comp_code' => $this->Session->read('Auth.Client.vc_comp_code'),
                        'ClaimHeader.vc_client_no' => $this->Session->read('Auth.Client.vc_client_no'),
                        'NOT' => array('ClaimHeader.vc_status' => 'STSTY08')),
                    'fields' => array('vc_claim_no', 'vc_claim_no')))
            );

            $this->set('claimNumber', $claimNumber);
            $this->set('claimdetailreport', $this->paginate('ClaimDetail'));

            $this->set('pagecounter', $pagecounter);
            $this->set('limit', $limit);
            $this->set('fromDate', $fromDate);
            $this->set('toDate', $toDate);
            $this->set('claim_status', $claim_status);
            $calaim_date = !empty($calaim_date) ? date('d M Y', strtotime($calaim_date)) : '';
            $this->set('calaim_date', $calaim_date);
            $this->set('claimNo', $claimNo);
        } catch (Exception $e) {
            echo "Exception Caught : ", $e->getMessage(), "\n";
        }
        $this->layout = 'flr_layout';
        $this->set('title_for_layout', " Claim Detail Report ");
    }

    /**
     * 
     * Get claim date and status
     */
    function flr_getClaimDetails() {

        $this->layout = false;
        if ($this->params['isAjax']) {
            $param = $this->params['data'];
        }
        $this->loadModel('ClaimHeader');
        $claimdetails = $this->ClaimHeader->find('first', array('conditions' => array('ClaimHeader.vc_claim_no' => $param),
            'fields' => array('dt_entry_date', 'vc_status')
        ));
        $sendOutput = array(
            'dt_entry_date' => date('d M Y', strtotime($claimdetails['ClaimHeader']['dt_entry_date'])),
            'vc_status' => $this->globalParameterarray[$claimdetails['ClaimHeader']['vc_status']],
        );
        echo json_encode($sendOutput);
        exit;
    }

    /**
     * Generat pdf report for cliamdetails
     * 
     */
    public function flr_claimdetailspdf() {

        try {
            $this->loadModel('ClaimHeader');
            $this->loadModel('ClaimDetail');
            $this->loadModel('ClaimprocessData');

            $vc_client_no = $this->Session->read('Auth.Client.vc_client_no');
			
			
			 $this->ClaimDetail->unbindModel(array('belongsTo' => array('ClaimHeader')) );
/*
            $fields = array('ClaimHeader.vc_comp_code', 'ClaimHeader.vc_claim_no', 'ClaimHeader.vc_client_no',
                'ClaimHeader.vc_payment_status', 'ClaimHeader.nu_payment_amount', 'ClaimHeader.ch_email_flag',
                'ClaimHeader.vc_status',
                'ClaimHeader.vc_party_claim_no',
                'ClaimDetail.vc_client_no',
                'ClaimDetail.vc_invoice_no',
                'ClaimDetail.dt_invoice_date',
                'ClaimHeader.dt_entry_date',
                'ClaimDetail.nu_litres',
                'ClaimDetail.nu_refund_rate',
                'ClaimDetail.vc_status',
                'ClaimDetail.nu_amount',
                'ClaimDetail.vc_outlet_code',
                'ClaimDetail.vc_reasons',
            );
			
			*/
			$fields = array('ClaimHeader.vc_comp_code', 'ClaimHeader.vc_claim_no', 'ClaimHeader.vc_client_no', 'ClaimHeader.vc_party_claim_no', 'ClaimHeader.vc_payment_status', 'ClaimHeader.nu_payment_amount', 'ClaimHeader.ch_email_flag',
                'ClaimHeader.vc_status', 'ClaimDetail.vc_client_no', 'ClaimDetail.vc_invoice_no',
                'ClaimDetail.dt_invoice_date', 'ClaimHeader.dt_entry_date', 'ClaimDetail.nu_litres',
                'ClaimDetail.nu_refund_rate', 'ClaimDetail.vc_status', 'ClaimDetail.nu_amount',
                'ClaimDetail.vc_outlet_code', 'ClaimDetail.vc_reasons');

            if (isset($this->params['named']['fromDate'])):
                $fromDate = date('Y-M-d', strtotime($this->params['named']['fromDate']));

            else :
                $fromDate = (isset($this->data['Claimdetailsreportpdf']['fromDate']) &&
                        !empty($this->data['Claimdetailsreportpdf']['fromDate'])) ?
                        date('Y-M-d', strtotime($this->data['Claimdetailsreportpdf']['fromDate'])) :
                        '';
            endif;

            if (isset($this->named['Claimdetailsreportpdf']['toDate'])) :
                $toDate = date('Y-M-d 23:59:59', strtotime($this->named['Claimdetailsreportpdf']['toDate']));

            else :
                $toDate = (isset($this->data['Claimdetailsreportpdf']['toDate']) &&
                        !empty($this->data['Claimdetailsreportpdf']['toDate'])) ?
                        date('Y-M-d 23:59:59', strtotime($this->data['Claimdetailsreportpdf']['toDate'])) :
                        '';
            endif;

            if (isset($this->named['Claimdetailsreportpdf']['claimNo'])) :
                $claimNo = $this->named['Claimdetailsreportpdf']['claimNo'];
            else :
                $claimNo = (isset($this->data['Claimdetailsreportpdf']['claimNo']) &&
                        !empty($this->data['Claimdetailsreportpdf']['claimNo'])) ?
                        $this->data['Claimdetailsreportpdf']['claimNo'] :
                        '';
            endif;



            $conditions = array();

            if ($fromDate):
                $conditions+= array(
                    'ClaimHeader.dt_entry_date >=' => $fromDate,
                );

            endif;

            if ($toDate):

                $conditions+= array(
                    'ClaimHeader.dt_entry_date <=' => $toDate,
                );

            endif;

            if ($claimNo):

                $conditions+= array(
                    'ClaimDetail.vc_claim_no' => $claimNo);

            endif;

            $limit = 10;

            $conditions += array(
                'NOT' => array('ClaimHeader.vc_status' => 'STSTY08'),
                array('ClaimHeader.vc_claim_no = ClaimDetail.vc_claim_no'),
                array('ClaimHeader.vc_client_no' => $vc_client_no));

            $options['joins'] = array(
                array('table' => 'HD_CLAIM_FLR',
                    'alias' => 'ClaimHeader',
                    'type' => 'INNER',
                    'conditions' => $conditions));

            $options['fields'] = $fields;
			
		//	pr($options);
			$this->ClaimDetail->unbindModel(
                    array('belongsTo' => array('ClaimHeader'))
            );
			//	pr($this->ClaimDetail);
			//die;
  /*          $this->paginate = array(
                'joins' => $options['joins'],
                'fields' => $options['fields'],
                'order' => array('ClaimDetail.vc_claim_no' => 'desc',
                    'ClaimDetail.dt_invoice_date' => 'desc'),
                    //'limit' => $limit
            );
*/
            //$claimdetailreportpdf = $this->paginate('ClaimDetail');
		
			$options['order'] = array('ClaimDetail.vc_claim_no' => 'desc',
                    'ClaimDetail.dt_invoice_date' => 'desc');
			$claimdetailreportpdf = $this->ClaimDetail->find('all',$options);
//die;
            $this->set('claimdetailreportpdf', $claimdetailreportpdf);
            $this->set('fromDate', $fromDate);
            $this->set('toDate', $toDate);
            $claimNo = $this->data['Claimdetailsreportpdf']['claimNo'];

            $columnsValues = array('SI.No.', "System Claim No.",
                'Invoice No.', 'Invoice Date',
                'Fuel Outlet', 'Fuel Volume (litres)', 'Refund Rate',
                'Invoice Status', 'Reason for rejection',
                'Amount (N$)', "Claim No.");

            $this->Flrreportpdfcreator->headerData('Claim Detail Report', $period = NULL, $this->Session->read('Auth'), $claimdetailreportpdf);

            $this->Flrreportpdfcreator->genrate_flr_claimdetail_pdf($columnsValues, $claimdetailreportpdf, $this->globalParameterarray, $this->Session->read('Auth.Client'), $toDate, $fromDate, $claimNo, $total_amount = null, $total_liters = null);
            $vc_client_no = $this->Session->read('Auth.Client.vc_client_no');


            $this->Flrreportpdfcreator->output($vc_client_no . '-Claim-Detail-Report' . '.pdf', 'D');
            die;
        } catch (Exception $e) {

            echo "Exception Caught : ", $e->getMessage(), "\n";
        }
    }

    /**
     * 
     * Claim Summary 
     * 
     */
    public function flr_claimsummarys() {

        try {

            $this->loadModel('ClaimHeader');
            $this->loadModel('ClaimDetail');
            if (isset($this->params['named']['fromDate'])):
                $fromDate = date('d-M-Y', strtotime($this->params['Claimsummaryreport']['fromDate']));

            else :
                $fromDate = (isset($this->data['Claimsummaryreport']['fromDate']) &&
                        !empty($this->data['Claimsummaryreport']['fromDate'])) ?
                        date('d-M-Y', strtotime($this->data['Claimsummaryreport']['fromDate'])) :
                        '';
            endif;

            if (isset($this->params['named']['toDate'])) :
                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['toDate']));

            else :
                $toDate = (isset($this->data['Claimsummaryreport']['toDate']) &&
                        !empty($this->data['Claimsummaryreport']['toDate'])) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Claimsummaryreport']['toDate'])) :
                        '';
            endif;

            $conditions = array(
                'ClaimHeader.vc_comp_code' => $this->Session->read('Auth.Client.vc_comp_code'),
                'ClaimHeader.vc_client_no' => $this->Session->read('Auth.Client.vc_client_no'),
                'NOT' => array('ClaimHeader.vc_status' => 'STSTY08'));


            if ($fromDate):

                $conditions += array(
                    'ClaimHeader.dt_entry_date >=' => $fromDate,
                );

            endif;

            if ($toDate):

                $conditions += array(
                    'ClaimHeader.dt_entry_date <=' => $toDate,
                );

            endif;

            $limit = 10;
            $this->paginate = array(
                'conditions' => $conditions,
                'order' => array('ClaimHeader.dt_entry_date' => 'desc', 'ClaimHeader.vc_claim_no' => 'desc'),
                'limit' => $limit
            );

            $pagecounter = (isset($this->params['named']['page']) && $this->params['named']['page'] > 1) ? $this->params['named']['page'] : 1;
            $this->set('claimsummaryreport', $this->paginate('ClaimHeader'));
            $this->set('pagecounter', $pagecounter);
            $this->set('limit', $limit);

            $this->set('fromDate', $fromDate);
            $this->set('toDate', $toDate);
        } catch (Exception $e) {
            echo " Exception Caught ", $e->getMessage(), "\n";
        }
        $this->layout = 'flr_layout';
        $this->set('title_for_layout', " Claim Summary Report ");
    }

    /**
     * Claim Summarys pdf
     * 
     * 
     */
    public function flr_claimsummaryspdf() {

        try {
            $this->loadModel('ClaimHeader');
            if (isset($this->params['named']['fromDate'])):
                $fromDate = date('d-M-Y', strtotime($this->params['Claimsummaryreportpdf']['fromDate']));

            else :
                $fromDate = (isset($this->data['Claimsummaryreportpdf']['fromDate']) &&
                        !empty($this->data['Claimsummaryreportpdf']['fromDate'])) ?
                        date('d-M-Y', strtotime($this->data['Claimsummaryreportpdf']['fromDate'])) :
                        '';
            endif;

            if (isset($this->params['named']['toDate'])) :
                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['toDate']));

            else :
                $toDate = (isset($this->data['Claimsummaryreportpdf']['toDate']) &&
                        !empty($this->data['Claimsummaryreportpdf']['toDate'])) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Claimsummaryreportpdf']['toDate'])) :
                        '';
            endif;

            $conditions = array(
                'ClaimHeader.vc_comp_code' => $this->Session->read('Auth.Client.vc_comp_code'),
                'ClaimHeader.vc_client_no' => $this->Session->read('Auth.Client.vc_client_no'),
                'NOT' => array('ClaimHeader.vc_status' => 'STSTY08'));

            if ($fromDate):
                $conditions += array(
                    'ClaimHeader.dt_entry_date >=' => $fromDate,
                );

            endif;

            if ($toDate):
                $conditions += array(
                    'ClaimHeader.dt_entry_date <=' => $toDate,
                );

            endif;

            $claimsummaryreportpdf = $this->ClaimHeader->find('all', array(
                'conditions' => $conditions,
                'order' => array('ClaimHeader.dt_entry_date' => 'desc', 'ClaimHeader.vc_claim_no' => 'desc')
            ));

            $this->set('claimsummaryreportpdf', $claimsummaryreportpdf);
            $this->set('fromDate', $fromDate);
            $this->set('toDate', $toDate);

            $columnsValues = array('SI.No.', "System Claim No.",
                'Claim Date', 'Claim Period From - To',
                'No. of invoice', 'Fuel Volume (ltrs)', 'Claim Status',
                'Amount (N$)', 'Claim No.');


            $this->Flrreportpdfcreator->headerData('Claim Summary Report', $period = NULL, $this->Session->read('Auth'), $claimsummaryreportpdf);
            $this->Flrreportpdfcreator->genrate_flr_claimsummary_pdf($columnsValues, $claimsummaryreportpdf, $this->globalParameterarray, $this->Session->read('Auth.Client'), $toDate, $fromDate, $total_amount = null);
            $vc_client_no = $this->Session->read('Auth.Client.vc_client_no');


            $this->Flrreportpdfcreator->output($vc_client_no . '-Claim-Summary-Report' . '.pdf', 'D');
			   die;

            //$this->layout = 'pdf';
        } catch (Exception $e) {
            echo " Exception Caught ", $e->getMessage(), "\n";
        }
    }

    /**
     * 
     * Payment Details
     * 
     */
    public function flr_paymentdetails() {

        try {
            $this->loadModel('ClaimHeader');
            if (isset($this->params['named']['fromDate'])) :
                $fromDate = date('d-M-Y', strtotime($this->params['Paymentreport']['fromDate']));

            else :

                $fromDate = (isset($this->data['Paymentreport']['fromDate']) && !empty($this->data['Paymentreport']['fromDate'])) ? date('d-M-Y', strtotime($this->data['Paymentreport']['fromDate'])) : '';

            endif;

            if (isset($this->params['named']['toDate'])):
                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['toDate']));
            else :
                $toDate = (isset($this->data['Paymentreport']['toDate']) && !empty($this->data['Paymentreport']['toDate'])) ? date('d-M-Y 23:59:59', strtotime($this->data['Paymentreport']['toDate'])) :
                        '';

            endif;

            $conditions = array(
                'ClaimHeader.vc_comp_code' => $this->Session->read('Auth.Client.vc_comp_code'),
                'ClaimHeader.vc_client_no' => $this->Session->read('Auth.Client.vc_client_no'),
                'NOT' => array('ClaimHeader.vc_status' => 'STSTY08'));

            if ($fromDate):

                $conditions += array('ClaimHeader.dt_entry_date >=' => $fromDate,);

            endif;

            if ($toDate):

                $conditions += array('ClaimHeader.dt_entry_date <=' => $toDate,);

            endif;

            $limit = 10;

            $this->paginate = array(
                'conditions' => $conditions,
                'order' => array('ClaimHeader.dt_entry_date' => 'desc', 'ClaimHeader.vc_claim_no' => 'desc'),
                'limit' => $limit
            );

            $pagecounter = (isset($this->params['named']['page']) && $this->params['named']['page'] > 1) ? $this->params['named']['page'] : 1;

            $this->set('paymentreport', $this->paginate('ClaimHeader'));
            $this->set('pagecounter', $pagecounter);
            $this->set('limit', $limit);

            $this->set('fromDate', $fromDate);
            $this->set('toDate', $toDate);
        } catch (Exception $e) {
            echo "Caught Exception :", $e->getMessage(), "\n";
        }



        $this->set('title_for_layout', " Payment Detail Report ");
    }

    /**
     * Payment details pdf
     * 
     * 
     */
    public function flr_paymentdetailspdf() {

        Configure::write('debug', 0);
        try {

            $this->loadModel('ClaimHeader');
            $this->loadModel('ClaimDetail');

            if (isset($this->params['named']['fromDate'])) :
                $fromDate = date('d-M-Y', strtotime($this->params['Paymentreportpdf']['fromDate']));

            else :

                $fromDate = (isset($this->data['Paymentreportpdf']['fromDate']) &&
                        !empty($this->data['Paymentreportpdf']['fromDate'])) ? date('d-M-Y', strtotime($this->data['Paymentreportpdf']['fromDate'])) : '';

            endif;

            if (isset($this->params['named']['toDate'])):

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['toDate']));

            else :

                $toDate = (isset($this->data['Paymentreportpdf']['toDate']) && !empty($this->data['Paymentreportpdf']['toDate'])) ? date('d-M-Y 23:59:59', strtotime($this->data['Paymentreportpdf']['toDate'])) : '';

            endif;

            $conditions = array(
                'ClaimHeader.vc_comp_code' => $this->Session->read('Auth.Client.vc_comp_code'),
                'ClaimHeader.vc_client_no' => $this->Session->read('Auth.Client.vc_client_no'),
                'NOT' => array('ClaimHeader.vc_status' => 'STSTY08'));

            if ($fromDate):

                $conditions += array(
                    'ClaimHeader.dt_entry_date >=' => $fromDate,
                );

            endif;

            if ($toDate):

                $conditions += array(
                    'ClaimHeader.dt_entry_date <=' => $toDate,
                );

            endif;

            $paymentreportpdf = $this->ClaimHeader->find('all', array(
                'conditions' => $conditions,
                'order' => array('ClaimHeader.dt_entry_date' => 'desc', 'ClaimHeader.vc_claim_no' => 'desc')
            ));


            $this->set('paymentreportpdf', $paymentreportpdf);
            $this->set('fromDate', $fromDate);
            $this->set('toDate', $toDate);

            $columnsValues = array('SI.No.', "System Claim No.",
                'Claim Date', 'Claim Period From - To',
                'Fuel Claimed (ltrs)', 'Amount (N$)',
                'Payment Status', 'Payment Amount (N$)',
                'Payment Date', 'Claim No.');
            //	pr($paymentreportpdf);die;
            $this->Flrreportpdfcreator->headerData('Payment Detail Report', $period = NULL, $this->Session->read('Auth'), $paymentreportpdf);

            $this->Flrreportpdfcreator->genrate_flr_paymentdetials_pdf($columnsValues, $paymentreportpdf, $this->globalParameterarray, $this->Session->read('Auth.Client'), $toDate, $fromDate);

            $vc_client_no = $this->Session->read('Auth.Client.vc_client_no');

            $this->Flrreportpdfcreator->output($vc_client_no . '-Claim-PaymentDetails-Report' . '.pdf', 'D');
            die;

            //$this->layout = 'flr_layout';
        } catch (Exception $e) {
            echo "Caught Exception :", $e->getMessage(), "\n";
        }
    }

}

?>
