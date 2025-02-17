<?php
use yii\helpers\Html;
//use yii\widgets\DetailView;
use yii\widgets\Pjax;

use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\AuthItem */

//$this->title = $model->name;
$this->title = Yii::t ( 'app', 'System Settings' );

$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

function getUserRoles($user_id){
	//print_r('Inside User Role');
	$connection = \Yii::$app->db;
	$sql="select auth_item.* from auth_item,auth_assignment where auth_item.type=1 and auth_assignment.user_id=$user_id and auth_assignment.item_name=auth_item.name";
	//print_r($sql);
	$command=$connection->createCommand($sql);
	$dataReader=$command->queryAll();
	$roles ='';
	if(count($dataReader) > 0){
		foreach($dataReader as $role){
			$roles.=$role['name']."</br>";
		}
	}
	
	return $roles;
}
function getUserOperations($user_id){
	$connection = \Yii::$app->db;
	$sql="select auth_item.* from auth_item,auth_assignment where auth_item.type=2 and auth_assignment.user_id=$user_id and auth_assignment.item_name=auth_item.name";
	$command=$connection->createCommand($sql);
	$dataReader=$command->queryAll();
	$roles ='';
	if(count($dataReader) > 0){
		foreach($dataReader as $role){
			$roles.=$role['name']."</br>";
		}
	}
	//print_r($roles.'----');
	return $roles;
}
function getUserAssignments(){
	if(!empty($_GET['assign_user_id'])){
		$connection = \Yii::$app->db;
		$sql="select auth_assignment.*,auth_item.type from auth_item, auth_assignment where  auth_assignment.user_id=$_GET[assign_user_id] and auth_assignment.item_name=auth_item.name";
		$command=$connection->createCommand($sql);
		$dataReader=$command->queryAll();
		if(count($dataReader) > 0){
			return $dataReader;
		}
	}else{
		return '';	
	}
}
function checkParentExists($parent,$child){
		$connection = \Yii::$app->db;
		$sql="select * from auth_item_child where  parent='$parent' and child='$child'";
		//print_r($sql);
		$command=$connection->createCommand($sql);
		$dataReader=$command->queryAll();
		if(count($dataReader) > 0){
			return 'yes';
		}else{
			return 'no';
		}
}
function countChild($parent){
		$connection = \Yii::$app->db;
		$sql="select * from auth_item_child where  parent='$parent'";
		$command=$connection->createCommand($sql);
		$dataReader=$command->queryAll();
		if(count($dataReader) > 0){
			return "[".count($dataReader)."]";
		}else{
			return '';
		}
}
function roleParent(){
		$connection = \Yii::$app->db;
		$sql="select auth_item_child.*,auth_item.type from auth_item, auth_item_child where auth_item_child.child=auth_item.name and auth_item_child.child='$_GET[role_id]'";
		///$sql="select * from auth_item_child where  parent='$_GET[role_id]'";
		$command=$connection->createCommand($sql);
		$dataReader=$command->queryAll();
		return $dataReader;
}
function roleChild(){
		$connection = \Yii::$app->db;
		$sql="select auth_item_child.*,auth_item.type from auth_item, auth_item_child where auth_item_child.parent=auth_item.name and auth_item_child.parent='$_GET[role_id]'";
		//$sql="select * from auth_item_child where  child='$_GET[role_id]'";
		$command=$connection->createCommand($sql);
		$dataReader=$command->queryAll();
		return $dataReader;
}
function operationParent(){
		$connection = \Yii::$app->db;
		$sql="select auth_item_child.*,auth_item.type from auth_item, auth_item_child where auth_item_child.child=auth_item.name and auth_item_child.child='$_GET[operation_id]'";
		///$sql="select * from auth_item_child where  parent='$_GET[role_id]'";
		$command=$connection->createCommand($sql);
		$dataReader=$command->queryAll();
		return $dataReader;
}
function operationChild(){
		$connection = \Yii::$app->db;
		$sql="select auth_item_child.*,auth_item.type from auth_item, auth_item_child where auth_item_child.parent=auth_item.name and auth_item_child.parent='$_GET[operation_id]'";
		//$sql="select * from auth_item_child where  child='$_GET[role_id]'";
		$command=$connection->createCommand($sql);
		$dataReader=$command->queryAll();
		return $dataReader;
}
function getRoleType($type){
	$connection = \Yii::$app->db;
	$sql="select auth_item.type from auth_item where  name ='$type'";
	$command=$connection->createCommand($sql);
	$dataReader=$command->queryOne();
	return $dataReader['type'];
}
function getDescription($id){
	$connection = \Yii::$app->db;
	$sql="select auth_item.description from auth_item where  name ='$id'";
	$command=$connection->createCommand($sql);
	$dataReader=$command->queryOne();
	return $dataReader['description'];
}
function getUserName($id){
	$connection = \Yii::$app->db;
	$sql="select username from user where  id ='$id'";
	$command=$connection->createCommand($sql);
	$dataReader=$command->queryOne();
	return $dataReader['username'];
}

?>

<!-- DataTables -->
<link rel="stylesheet" href="<?= Yii::getAlias('@web/theme') ?>/plugins/datatables/dataTables.bootstrap.css">

<style>	
.cke_contents{max-height:250px}
.slider .tooltip.top {
    margin-top: -36px;
    z-index: 100;
}
.close {
    color: #000000;
    float: right;
    font-size: 18px;
    font-weight: bold;
    line-height: 1;
    opacity: 0.2;
    text-shadow: 0 1px 0 #ffffff;
}
</style>

<div class="box box-default color-palette-box">
	<div class="box-header with-border">
		<h3 class="box-title">
			<i class="fa fa-gear">&nbsp;&nbsp;Role Based Access Control(RBAC) Setting</i>
		</h3>
	</div>
<div class="box-body">
	<!--
	<div class="page-header">
		<h1><?= Html::encode($this->title) ?></h1>
	</div>
	-->
    <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo Yii::t ( 'app', 'RBAC Setting' ); ?> <small class="m-l-sm"><?php echo Yii::t ( 'app', 'Changes will be at application level' ); ?></small></h5>
						<!--Commented to remove up arrow and cross button--[23-02-2017]>
                        <div class="ibox-tools">
						    <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
						
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>-->
                    </div>
					<div class="ibox-content">
						<div class="tabbable">
							<ul class="nav nav-tabs" id="myTab">
							<li class="active">
								<a href="#assignments" role="tab" data-toggle="tab"><?php echo Yii::t ( 'app', 'Assignments' ); ?></a>
							</li>
							<li ><a href="#permission" role="tab" data-toggle="tab"><?php echo Yii::t ( 'app', 'Permission' ); ?></a></li>
							<li><a href="#role" role="tab" data-toggle="tab"><?php echo Yii::t ( 'app', 'Roles' ); ?></a></li>
							<li><a href="#operations" role="tab" data-toggle="tab"><?php echo Yii::t ( 'app', 'Operations' ); ?></a></li>
							</ul>
					
							<div class="tab-content">
							
							<!--Div For Assignments--->
							<div class="tab-pane active" id="assignments"> 
                        	<br/>
                        	<?php if(empty($_GET['assign_user_id'])){ ?>
                        	<?php
								if(count($users) > 0){
								//print_r('Inside Assignment Tab'); ?>
                                <table class="table table-bordered table-striped" id="assignment_table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                           <!-- <th>Type</th>-->
                                            <th>Roles</th>
                                            <th>Operations</th>
                                        </tr>
                                     </thead>
                                     <tbody>
									<?php foreach($users  as $user){?>
                                        <tr>
                                            <td><a href="index.php?r=settings/rights&assign_user_id=<?=$user['id']?>"><?=$user['username']?></a></td>
                                            <td>
											<?php
                                            echo $user['email'];
											?>
                                            </td>
                                           
                                            <td>
											<?php
                                            echo getUserRoles($user['id']);
											?>
                                            </td>
                                            <td>
                                            	<?php
												//echo getUserOperations($user['id']);
												?>
												<a href="index.php?r=settings/rights&assign_user_id=<?=$user['id']?>" class="btn btn-primary btn-xs">Roles & Operations</a>
                                            </td>
							
                                        </tr>		
							<?php }	?>
                            	</tbody>
                            </table>

				

											
							<?php	}
							}else{
							?>
                            <h3><?=Yii::t('app', 'Assignment for User')?> : <?= getUserName($_GET['assign_user_id'])?></h3>
                        	<form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                                <?php Yii::$app->request->enableCsrfValidation = true; ?>
                                <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
                                <div class="form-group">
                                	<div class="col-sm-6">
                                        <?php
											if(getUserAssignments() !=''){?>
                                            
                                    	<table class="table table-bordered table-striped">
										<?php 		
											foreach(getUserAssignments() as $assign){
										?>
                                        	<tr>
                                            	<td><?=$assign['item_name']?></td>
                                                <td><?=Yii::t('app',$assign['type']=='1'?'Role':'Operation')?></td>
                                                <td width="100"><a href="index.php?r=settings/rights&assign_user_id=<?=$_GET['assign_user_id']?>&assign_user_remove=<?= urlencode($assign['item_name'])?>" onClick="return confirm('<?=Yii::t('app','Are you Sure!')?>')" class="btn btn-danger btn-xs" ><?=Yii::t('app',"Remove")?></a></td>
                                            </tr>
                                        <?php } ?>
                                        </table>
										<?php } else{
											echo Yii::t('app',"no assignment");
										}
											?>
                                            <a href="index.php?r=settings/rights" class="btn btn-primary  btn-sm"><?=Yii::t('app',"Back")?></a>
                                    </div>
                                	<div class="col-sm-4">
                                    	<?php 
											/*if(count($assigment_error) >0){?>
											<div class="alert alert-danger">
                                            	<?php
													foreach($assigment_error as $errors){
														foreach($errors as $error){	?>
													<li><?=$error?></li>		
												<?php	}
													}
												?>
                                            </div>	
										<?php }	*/ ?>
                                    	<select name="auth_item" class="form-control">
                                        	<optgroup label="Roles">
                                            	<?php
													if(count($roles) > 0){
														foreach($roles as $role){?>
														<option><?=$role['name']?></option>	
													<?php	}
													}
												?>
                                            </optgroup>
                                            <optgroup label="Operations">
                                            	<?php
													if(count($operations) > 0){
														foreach($operations as $operation){?>
														<option><?=$operation['name']?></option>	
													<?php	}
													}
												?>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                    	<?= Html::submitButton(Yii::t ( 'app', 'Assign' ), ['class' => 'btn btn-primary btn-block']) ?>
                                    </div>
                                    
                                </div>
                            
                     </form>
                     <?php } ?>
                    </div>
						<!--Permission--->
						 <div class="tab-pane" id="permission"> 
                             <br/>
                             <h3><?=Yii::t('app',"Permissions")?></h3>
                             <table class="table table-bordered table-striped" id="permission_table">
                             	<thead>
                                	<tr>
                                    	<th><?=Yii::t('app',"Item")?></th>
                                        <?php
											foreach($roles as $roleCol){
										?>
                                        <th><?=Yii::t('app',$roleCol['name'])?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php foreach($operations as $opRow){ ?>
                                       
                                       
                                	<tr>
                                    	 <td><?=$opRow['name']?></td>
                                    	<?php
											foreach($roles as $roleCol){
										?>
                                        <td>
											<?php 
												if(checkParentExists($roleCol['name'],$opRow['name']) =='yes'){?>
												<a href="index.php?r=settings/rights&child=<?=urlencode($opRow['name'])?>&parent=<?=urlencode($roleCol['name'])?>&remove_child=true" class="btn btn-danger btn-xs"  onClick="return confirm('<?=Yii::t('app','Are you Sure!')?>')"><?=Yii::t('app',"Remove")?></a>	
											<?php }else{ ?>
													<a href="index.php?r=settings/rights&child=<?=urlencode($opRow['name'])?>&parent=<?=urlencode($roleCol['name'])?>" class="btn btn-primary btn-xs"><?=Yii::t('app','Assign')?></a>		
											<?php	} ?>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                     <?php } ?>
                                </tbody>
                             </table>
                        </div>
						<!--End Permisson-->
						<!--Role-->
						<div class="tab-pane" id="role"> 
                            <br/>
                            
                            <?php
							if(empty($_GET['add_role']) && empty($_GET['role_id'])){
							
							//exit;
							?>
							
                            	<h3><?=Yii::t('app',"Roles")?></h3>
                                <a href="index.php?r=settings/rights&add_role=true" class="btn btn-success btn-sm"><?=Yii::t('app',"Add New")?></a
								><?php if(count($roles) > 0){
								 ?>
                               <table class="table table-bordered table-striped">
                               		<thead>
                                    	<tr>
                                        	<th><?=Yii::t('app',"Name")?></th>
                                            <th><?=Yii::t('app',"Description")?></th>
                                            <!--<th>Business Role</th>-->
                                            <th><?=Yii::t('app',"Data")?></th>
                                            <th><?=Yii::t('app',"Action")?></th>
                                            
                                        </tr>
                                    </thead>
								<?php	foreach($roles as $role){?>
									<tr>
										<td><a href="index.php?r=settings/rights&role_id=<?=$role['name']?>"><?=$role['name']." ".countChild($role['name'])?></a></td>
                                        <td><?=$role['description']?></td>
                                       <!-- <td><?=$role['name']?></td>-->
                                        <td><?=$role['data']?></td>
                                        <td>
                                        <?php
											if(!in_array($role['name'],array('Admin','Customer'))){
										?>
                                        <a href="index.php?r=settings/rights&role_del=<?=$role['name']?>" onClick="return confirm('<?=Yii::t('app','Are you Sure!')?>')" class="btn btn-danger btn-xs"><?=Yii::t('app',"Remove")?></a>
                                        <?php } ?>
                                        </td>
									</tr>	
								<?php	}?>
                                </table>
							<?php	}else echo Yii::t('app',"No Data");
							}
							if(!empty($_GET['add_role']) && empty($_GET['role_id'])){
							//var_dump($_GET['role_id'].'----');
							//exit;
							?>
                            	<h3><?=Yii::t('app',"Add Role")?></h3>
                            	<form method="post" class="form-horizontal" action="" enctype="multipart/form-data" id="role_frm">
                                <?php Yii::$app->request->enableCsrfValidation = true; ?>
                                <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
                                	<?php 
										
										/*if(count($role_add_error) >0){?>
										<div class="alert alert-danger">
											<?php
												foreach($role_add_error as $errors){
													foreach($errors as $error){	?>
												<li><?=$error?></li>		
											<?php	}
												}
											?>
										</div>	
									<?php } */?>
                                	<div class="form-group">
                                    	<div class="col-sm-4">
                                        	<label><?=Yii::t('app',"Name")?> <font color="#FF0000">*</font></label>
                                        	<input type="text" class="form-control" name="role_name" id="role_name" data-validation="required" value="<?= isset($_POST['role_name'])?$_POST['role_name']:''?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<div class="col-sm-4">
                                        	<label><?=Yii::t('app',"Description")?> <font color="#FF0000">*</font></label>
                                        	<input type="text" class="form-control" name="role_description" id="role_description" value="<?= isset($_POST['role_description'])?$_POST['role_description']:''?>" data-validation="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<div class="col-sm-4">
                                        	<label><?=Yii::t('app',"Data")?></label>
                                        	<input type="text" class="form-control" name="role_data" value="<?= isset($_POST['role_data'])?$_POST['role_data']:''?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<div class="col-sm-2">
                                    	<?= Html::submitButton(Yii::t ( 'app', 'Save' ), ['class' => 'btn btn-primary  btn-sm role_add']) ?>
                                    </div>
                                        <div class="col-sm-2" align="right">
                                        	<a href="index.php?r=settings/rights" class="btn btn-primary  btn-sm"><?=Yii::t('app',"Back")?></a>
                                        </div>
                                    </div>
                                </form>
                            <?php }
							if(!empty($_GET['role_id'])){?>
                            	<h3><?=Yii::t('app',"Role")?> : <?=$_GET['role_id']?></h3>
                                <div class="form-group">
                                	<div class="row">
                                	<div class="col-sm-6">
                                    	<h3><?=Yii::t('app',"Relations")?></h3>
                                        <h4><?=Yii::t('app',"Parent")?></h4>
                                        <?php
											if(count(roleParent()) > 0){?>
                                            
                                    	<table class="table table-bordered table-striped">
										<?php 		
											foreach(roleParent() as $roleParent){
										?>
                                        	<tr>
                                            	<td><?=$roleParent['parent']?></td>
                                                <td><?=Yii::t('app',getRoleType($roleParent['parent'])=='2'?'Role':'Operation')?></td>
                                                <!--<td>
                                                	<a href="index.php?r=liveobjects/setting/rights&child=<?=urlencode($_GET['role_id'])?>&parent=<?=urlencode($roleParent['name'])?>&role_child_del=true&role_id=<?=urlencode($_GET['role_id'])?>" class="btn btn-danger btn-xs"  onClick="return confirm('<?=Yii::t('app','Are you Sure!')?>')">Remove</a>
                                                </td>-->
                                            </tr>
                                        <?php } ?>
                                        </table>
										<?php } else{
											echo Yii::t('app',"This item has no parents.");
										}
											?>
                                            <h4><?=Yii::t('app',"Children")?></h4>
                                            <?php
											if(count(roleChild()) > 0){?>
                                            
                                    	<table class="table table-bordered table-striped">
										<?php 		
											foreach(roleChild() as $roleChild){
										?>
                                        	<tr>
                                            	<td><?=$roleChild['child']?></td>
                                                <td><?=Yii::t('app',getRoleType($roleChild['child'])=='2'?'Role':'Operation')?></td>
                                                <td>
                                                	<a href="index.php?r=settings/rights&child=<?=urlencode($roleChild['child'])?>&parent=<?=urlencode($_GET['role_id'])?>&role_child_del=true&role_id=<?=urlencode($_GET['role_id'])?>" class="btn btn-danger btn-xs"  onClick="return confirm('<?=Yii::t('app','Are you Sure!')?>')"><?=Yii::t('app','Remove')?></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </table>
										<?php } else{
											echo Yii::t('app',"This item has no children.");
										}
											?>
                                            <br/><a href="index.php?r=settings/rights" class="btn btn-primary btn-sm"><?=Yii::t('app',"Back")?></a>
                                    </div>
                                	<div class="col-sm-4 col-sm-offset-2">
                                    	<h3><?=Yii::t('app',"Update Role")?></h3>
                                        <form method="post" action="" enctype="multipart/form-data">
                                <?php Yii::$app->request->enableCsrfValidation = true; ?>
                                <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
                                	<label><?=Yii::t('app',"Role")?></label>
                                	<input type="text" readonly class="form-control" value="<?=$_GET['role_id']?>">
                                    <label><?=Yii::t('app',"Description")?></label>
                                    <input type="text" name="edit_role_description" value="<?=getDescription($_GET['role_id'])?>" class="form-control"><br/>
                                    <?= Html::submitButton(Yii::t ( 'app', 'Update' ), ['class' => 'btn btn-primary  btn-sm']) ?>
                                </form>
                                    	<h3><?=Yii::t('app',"Add Child")?></h3>
                                    	<?php 
											/*if(count($roleChild_assigment_error) >0){?>
											<div class="alert alert-danger">
                                            	<?php
													foreach($roleChild_assigment_error as $errors){
														foreach($errors as $error){	?>
													<li><?=$error?></li>		
												<?php	}
													}
												?>
                                            </div>	
										<?php }	*/ ?>
                                        
								<form method="post"  action="" enctype="multipart/form-data">
                                <?php Yii::$app->request->enableCsrfValidation = true; ?>
                                <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
                                    	<select name="role_child_auth_item" class="form-control">
                                        <optgroup label="Roles">
                                            	<?php
													if(count($roles) > 0){
														foreach($roles as $role){?>
														<option><?=$role['name']?></option>	
													<?php	}
													}
												?>
                                            </optgroup>
                                            <optgroup label="Operations">
                                            	<?php
													if(count($operations) > 0){
														foreach($operations as $operation){?>
														<option><?=$operation['name']?></option>	
													<?php	}
													}
												?>
                                            </optgroup>
                                        </select>
                                        <br/>
										<?= Html::submitButton(Yii::t ( 'app', 'Save' ), ['class' => 'btn btn-primary  btn-sm']) ?>
                            
                     				</form>
                                    </div>
                                    </div>
                                </div>
							<?php } ?>
                        </div>
						<!--End Role-->
						
						<!--Operation Tab--->
							<div class="tab-pane" id="operations"> 
							<?php if(empty($_GET['add_operation']) && empty($_GET['operation_id'])){ ?>
								 <h3><?=Yii::t('app',"Operations")?></h3>
								 <a href="index.php?r=settings/rights&add_operation=true" class="btn btn-success btn-sm"><?=Yii::t('app',"Add New")?></a>
								 <br>
								 <table class="table table-bordered table-striped" id="operation_table">
                               		<thead>
                                    	<tr>
                                        	<th><?=Yii::t('app',"Name")?></th>
                                            <th><?=Yii::t('app',"Description")?></th>
                                            <th><?=Yii::t('app',"Data")?></th>
                                            <th><?=Yii::t('app',"Action")?></th>
                                        </tr>
                                    </thead>
								<?php	foreach($operations as $operation){?>
									<tr>
										<td><?=$operation['name']?></td>
                                        <td><?=$operation['description']?></td>
                                        <td><?=$operation['data']?></td>
                                        <td><a href="index.php?r=settings/rights&operation_del=<?=$operation['name']?>" onClick="return confirm('<?=Yii::t('app','Are you Sure!')?>')" class="btn btn-danger btn-xs"><?=Yii::t('app',"Remove")?></a></td>					</tr>	
								<?php	}?>
                                </table>
								 <?php }
								 if(!empty($_GET['add_operation']) && empty($_GET['operation_id'])){
								 ?>
                            	<h3><?=Yii::t('app',"Add Operation")?></h3>
                            	<form method="post" class="form-horizontal" action="" id="operation_frm">
                                <?php Yii::$app->request->enableCsrfValidation = true; ?>
                                <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
                                	<?php 
										/*if(count($operation_add_error) >0){?>
										<div class="alert alert-danger">
											<?php
												foreach($operation_add_error as $errors){
													foreach($errors as $error){	?>
												<li><?=$error?></li>		
											<?php	}
												}
											?>
										</div>	
									<?php }	*/ ?>
                                	<div class="form-group">
                                    	<div class="col-sm-4">
                                        	<label><?=Yii::t('app',"Name")?> <font color="#FF0000">*</font></label>
                                        	<input type="text" class="form-control" name="operation_name" id="operation_name" data-validation="required" value="<?= isset($_POST['name'])?$_POST['name']:''?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<div class="col-sm-4">
                                        	<label><?=Yii::t('app',"Description")?> <font color="#FF0000">*</font></label>
                                        	<input type="text" class="form-control" name="operation_description" id="operation_description" value="<?= isset($_POST['description'])?$_POST['description']:''?>" data-validation="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<div class="col-sm-4">
                                        	<label><?=Yii::t('app',"Data")?></label>
                                        	<input type="text" class="form-control" name="operation_data" value="<?= isset($_POST['data'])?$_POST['data']:''?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<div class="col-sm-2">
                                    	<?= Html::submitButton(Yii::t ( 'app', 'Save' ), ['class' => 'btn btn-primary  btn-sm operation_add']) ?>
                                    </div>
                                        <div class="col-sm-2" align="right">
                                        	<a href="index.php?r=settings/rights" class="btn btn-primary  btn-sm"><?=Yii::t('app',"Back")?></a>
                                        </div>
                                    </div>
                                </form>
                                
                            <?php } ?>
							</div>	
							<!--End Of Operation Tab-->
						</div>
					</div>
				</div>	
			</div>
		</div>
</div>
<!-- DataTables -->
<script src="<?= Yii::getAlias('@web/theme') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= Yii::getAlias('@web/theme') ?>/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
function Add_Error(obj,msg){
	 $(obj).parents('.form-group').addClass('has-error');
	 $(obj).parents('.form-group').append('<div style="color:#D16E6C; clear:both" class="error"><i class="icon-remove-sign"></i> '+msg+'</div>');
	 return true;
}
function Remove_Error(obj){
	$(obj).parents('.form-group').removeClass('has-error');
	$(obj).parents('.form-group').children('.error').remove();
	return false;
}
function Add_ErrorTag(obj,msg){
	obj.css({'border':'1px solid #D16E6C'});
	
	obj.after('<div style="color:#D16E6C; clear:both" class="error"><i class="icon-remove-sign"></i> '+msg+'</div>');
	 return true;
}
function Remove_ErrorTag(obj){
	obj.removeAttr('style').next('.error').remove();
	return false;
}
$(document).ready(function(e) {
  $('#role_frm').submit(function(event){
		var error='';
		$('#role_frm [data-validation="required"]').each(function(index, element) {
			//alert($(this).attr('id'));
			Remove_Error($(this));
			if($(this).val() == ''){
				error+=Add_Error($(this),'This Field is Required!');
			}else{
					Remove_Error($(this));							
			}
			if(error !=''){
				event.preventDefault();
			}else{
				return true;
			}
		});
	});
	$('#operation_frm').submit(function(event){
		var error='';
		$('#operation_frm [data-validation="required"]').each(function(index, element) {
			//alert($(this).attr('id'));
			Remove_Error($(this));
			if($(this).val() == ''){
				error+=Add_Error($(this),'This Field is Required!');
			}else{
					Remove_Error($(this));							
			}
			if(error !=''){
				event.preventDefault();
			}else{
				return true;
			}
		});
	});  
});

//Script to get back on current active tab

								
	$(document).ready(function(){
		$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
			localStorage.setItem('activeTab', $(e.target).attr('href'));
		});
		var activeTab = localStorage.getItem('activeTab');
		if(activeTab){
			$('#myTab a[href="' + activeTab + '"]').tab('show');
		}
	});

	//Assignment Table
	$('#assignment_table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
	
	//Permission Table
	$('#permission_table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
	
	//Operation Table 
	$('#operation_table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });



$(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#w0 a[href="' + activeTab + '"]').tab('show');
    }
});
</script>