<?php
/********************************************************************************* 
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2015 Sapplica
 *   
 *  Sentrifugo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Sentrifugo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Sentrifugo.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  Sentrifugo Support <support@sentrifugo.com>
 ********************************************************************************/

class Default_EmppayslipsController extends Zend_Controller_Action
{

	private $options;
	public function preDispatch()
	{
	}

	public function init()
	{

		$this->_options= $this->getInvokeArg('bootstrap')->getOptions();
	}

	public function indexAction()
	{

	}

	public function editAction()
	{
		if(defined('EMPTABCONFIGS'))
		{
			$empOrganizationTabs = explode(",",EMPTABCONFIGS);

		 	if(in_array('employeedocs',$empOrganizationTabs))
		 	{
			 	$auth = Zend_Auth::getInstance();
			 	if($auth->hasIdentity())
			 	{
			 		$loginUserId = $auth->getStorage()->read()->id;
					$loginuserGroup = $auth->getStorage()->read()->group_id;
			 		$loginUserRole = $auth->getStorage()->read()->emprole;
		 		}

			 	$id = $this->getRequest()->getParam('userid');
			 	
			 	try
			 	{
			 		if($id && is_numeric($id) && $id>0 && $id!=$loginUserId && ($loginuserGroup == HR_GROUP ||$loginuserGroup == MANAGEMENT_GROUP || $loginUserRole == SUPERADMIN))
					{
						$employeeModal = new Default_Model_Employee();
						$empdata = $employeeModal->getActiveEmployeeData($id);
						if(!empty($empdata))
						{
							$empDocuModel = new Default_Model_Emppayslips();
							$empDocuments = $empDocuModel->getEmpDocumentsByFieldOrAll('user_id',$id);

							$this->view->empDocumentpay = $empDocuments;
									//die(print_r($this->view->empDocumentpay));
						}
						
						$usersModel = new Default_Model_Users();
						$employeeData = $usersModel->getUserDetailsByIDandFlag($id);
						if(!empty($employeeData))
							$this->view->employeedata = $employeeData[0];
						$this->view->id = $id;
						$this->view->empdata = $empdata;
					} else {
				   		$this->view->rowexist = "norows";
					}
			 	}
			 	catch(Exception $e) {
		 			$this->view->rowexist = "norows";
		 		}
		 		// Show message to user when document was deleted by other user.
		 		$this->view->messages = $this->_helper->flashMessenger->getMessages();
			}else{
		 		$this->_redirect('error');
		 	}
		}else{
			$this->_redirect('error');
		}
	}


	public function viewAction()
	{
		if(defined('EMPTABCONFIGS'))
		{
			$empOrganizationTabs = explode(",",EMPTABCONFIGS);
		 	if(in_array('employeedocs',$empOrganizationTabs))
		 	{
			 	$auth = Zend_Auth::getInstance();
			 	if($auth->hasIdentity())
			 	{
			 		$loginUserId = $auth->getStorage()->read()->id;
					$loginuserGroup = $auth->getStorage()->read()->group_id;
					$loginUserRole = $auth->getStorage()->read()->emprole;
		 		}

			 	$id = $this->getRequest()->getParam('userid');
			 	
			 	try
			 	{
			 		if($id && is_numeric($id) && $id>0 && $id!=$loginUserId && ($loginuserGroup == HR_GROUP ||$loginuserGroup == MANAGEMENT_GROUP || $loginUserRole == SUPERADMIN))
					{
						$employeeModal = new Default_Model_Employee();
						$empdata = $employeeModal->getActiveEmployeeData($id);
						if(!empty($empdata))
						{
							$empDocuModel = new Default_Model_Emppayslips();
							$empDocuments = $empDocuModel->getEmpDocumentsByFieldOrAll('user_id',$id);

							$this->view->empDocumentpay = $empDocuments;
									//die(print_r($this->view->empDocumentpay));
						}
						
						$usersModel = new Default_Model_Users();
						$employeeData = $usersModel->getUserDetailsByIDandFlag($id);
						if(!empty($employeeData))
							$this->view->employeedata = $employeeData[0];
						$this->view->id = $id;
						$this->view->empdata = $empdata;
					} else {
				   		$this->view->rowexist = "norows";
					}
			 	}
			 	catch(Exception $e) {
		 			$this->view->rowexist = "norows";
		 		}
		 		// Show message to user when document was deleted by other user.
		 		$this->view->messages = $this->_helper->flashMessenger->getMessages();
			}else{
		 		$this->_redirect('error');
		 	}
		}else{
			$this->_redirect('error');
		}
	}

}
?>
