<?php

namespace backend\controllers;

use yii;
use common\models\AuthItem;
use common\models\AuthAssignment;
use common\models\AuthItemChild;
use common\models\search\UserSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingsController implements the CRUD actions for AuthItem model.
 */
class SettingsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class, //Replaced className() -> class as className is depricated
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all AuthItem models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $type = Yii::$app->request->get('type');
       
        $query = AuthItem::find();

        if ($type === '1') {
            $query->where(['type' => 1]); 
        } elseif ($type === '2') {
            $query->where(['type' => 2]); 
        }

        $dataProvider = new ActiveDataProvider([
            'query' =>  $query,
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'type' => $type,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $name Name
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($name)
    {
        return $this->render('view', [
            'model' => $this->findModel($name),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $type = Yii::$app->request->get('type');
        $model = new AuthItem();

        $model->type = $type;
        /* print_r($this->request->post());
        exit() ; */

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $name Name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($name)
    {
        $model = $this->findModel($name);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'name' => $model->name]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name Name
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($name)
    {
        $this->findModel($name)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name Name
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name)
    {
        if (($model = AuthItem::findOne(['name' => $name])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionRights()
	{
		/* if(\Yii::$app->user->can('Setting.RBAC')){ */
		$searchModel = new UserSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
		
		//$model=new User;
		$connection = \Yii::$app->db;
		
		$sql="select * from user";
		
		$command=$connection->createCommand($sql);
		
		$users=$command->queryAll();
		
		$authItems = AuthItem::find()->asArray()->all();
		
		$roles = AuthItem::find()->where("type = 1")->asArray()->all();
		
		$operations = AuthItem::find()->where("type = 2")->asArray()->all();
       
        		
		// Remove Assigment User
		if(!empty($_GET['assign_user_remove'])){
		
			$item_name = urldecode($_GET['assign_user_remove']);
			if (($model = AuthAssignment::find()->where("user_id=$_GET[assign_user_id] and item_name='$item_name'")->one()) !== null) {
				$model->delete();
				 return $this->redirect(['rights', 'assign_user_id' => $_GET['assign_user_id']]);
			} else {
				throw new NotFoundHttpException('The requested page does not exist.');
			}
		}
		
		// Add Assigment User
		if(!empty($_POST['auth_item'])){
			$model = new AuthAssignment;
			$model->item_name = $_POST['auth_item'];
			$model->user_id =  $_GET['assign_user_id'];
			//print_r($model->item_name.'------'.$model->id);
			//exit;
			$model->save();
			
			//var_dump($model->errors);
			if(count($model->errors)>0){
				return $this->render('rights', [
					'users' => $users,
					'authItems' => $authItems,
					'operations' => $operations,
					'roles' => $roles,
					'dataProvider' => $dataProvider,
					'assigment_error' => $model->errors,
	
				]);
			}else
				 return $this->redirect(['rights', 'assign_user_id' => $_GET['assign_user_id']]);
		}
		// Remove Parent Child of Role
		if(!empty($_GET['parent']) && !empty($_GET['child']) && !empty($_GET['role_child_del'])){
			$authItemChildObj  = AuthItemChild::find()->where("parent='".urldecode($_GET['parent'])."' and child='".urldecode($_GET['child'])."'")->one();
			$authItemChildObj->delete();
			//var_dump($authItemChildObj->errors);
		return $this->redirect(['rights','role_id'=>$_GET['role_id']]);
			
		}
		// Remove Parent Child of Opration
		if(!empty($_GET['parent']) && !empty($_GET['child']) && !empty($_GET['operation_child_del'])){
			$authItemChildObj  = AuthItemChild::find()->where("parent='".urldecode($_GET['parent'])."' and child='".urldecode($_GET['child'])."'")->one();
			
			$authItemChildObj->delete();
			return $this->redirect(['rights','operation_id'=>$_GET['operation_id']]);
			
		}
		// Add Parent Child
		if(!empty($_GET['parent']) && !empty($_GET['child']) && empty($_GET['remove_child']) && empty($_GET['operation_child_del'])){
			$authItemChildObj  = new AuthItemChild;
			
			$authItemChildObj->parent = urldecode($_GET['parent']);
			$authItemChildObj->child = urldecode($_GET['child']);
			$authItemChildObj->save();
			 return $this->redirect(['rights']);
		}
		// Remove Parent Child
		if(!empty($_GET['parent']) && !empty($_GET['child']) && !empty($_GET['remove_child'])){
			$authItemChildObj  = AuthItemChild::find()->where("parent='".urldecode($_GET['parent'])."' and child='".urldecode($_GET['child'])."'")->one();
			
			$authItemChildObj->delete();
			return $this->redirect(['rights']);
		}
		// Add Role
		if(!empty($_POST['role_name']) && !empty($_POST['role_description'])){
			//print_r('Inside Add Role');
			$authItemObj = new AuthItem;
			$authItemObj->name = $_POST['role_name'];
			$authItemObj->description = $_POST['role_description'];
			$authItemObj->data = $_POST['role_data'];
			$authItemObj->type = 1;
			$authItemObj->save();
			//var_dump($authItemObj);
			//print_r('Inside Role Tab');
			if(count($authItemObj->errors)>0){
			//print_r('Inside Error Role');
			//exit;
				return $this->render('rights', [
					'users' => $users,
					'authItems' => $authItems,
					'operations' => $operations,
					'roles' => $roles,
					'dataProvider' => $dataProvider,
					'role_add_error' => $authItemObj->errors,
				]);
			}else
				 return $this->redirect(['rights']);
		}
		
		
	
		// Add Role child
		if(!empty($_POST['role_child_auth_item'])){
			$authItemChildObj  = new AuthItemChild;
			
			$authItemChildObj->parent = urldecode($_GET['role_id']);
			$authItemChildObj->child = urldecode($_POST['role_child_auth_item']);
			$authItemChildObj->save();
			///var_dump($authItemChildObj->errors);
			if(count($authItemChildObj->errors)>0){
				return $this->render('rights', [
					'users' => $users,
					'authItems' => $authItems,
					'operations' => $operations,
					'roles' => $roles,
					'dataProvider' => $dataProvider,
					'roleChild_assigment_error' => $authItemChildObj->errors,
	
				]);
			}else
				 return $this->redirect(['rights','role_id'=>$_GET['role_id']]);
		}
		// Update Role 
		if(!empty($_POST['edit_role_description'])){
			$authItemdObj  = AuthItem::find()->where("name='".$_GET['role_id']."' and type='2'")->one();
			if(!is_null($authItemdObj)){
			$authItemdObj->description = $_POST['edit_role_description'];
			$authItemdObj->save();
			///var_dump($authItemChildObj->errors);
			if(count($authItemdObj->errors)>0){
				return $this->render('rights', [
					'users' => $users,
					'authItems' => $authItems,
					'operations' => $operations,
					'roles' => $roles,
					'dataProvider' => $dataProvider,
					'roleChild_assigment_error' => $authItemdObj->errors,
	
				]);
			}else
				 return $this->redirect(['rights','role_id'=>$_GET['role_id']]);
			}
		}
		// Update Operation
		if(!empty($_POST['edit_operation_description'])){
			$authItemdObj  = AuthItem::find()->where("name='".$_GET['operation_id']."' and type='0'")->one();
			if(!is_null($authItemdObj)){
			$authItemdObj->description = $_POST['edit_operation_description'];
			$authItemdObj->save();
			///var_dump($authItemChildObj->errors);
			if(count($authItemdObj->errors)>0){
				return $this->render('rights', [
					'users' => $users,
					'authItems' => $authItems,
					'operations' => $operations,
					'roles' => $roles,
					'dataProvider' => $dataProvider,
					'operationChild_assigment_error' => $authItemdObj->errors,
	
				]);
			}else
				 return $this->redirect(['rights','operation_id'=>$_GET['operation_id']]);
			}
		}
		// Add operation
		if(!empty($_POST['operation_name']) && !empty($_POST['operation_description'])){
			//print_r('Inside Operation');
			//exit;
			$authItemObj = new AuthItem;
			///print_r($authItemObj);
			$authItemObj->name = $_POST['operation_name'];
			$authItemObj->description = $_POST['operation_description'];
			$authItemObj->data = $_POST['operation_data'];
			$authItemObj->type = 2;
			$authItemObj->save();
			///var_dump($authItemObj->errors);
			if(count($authItemObj->errors)>0){
				return $this->render('rights', [
					'users' => $users,
					'authItems' => $authItems,
					'operations' => $operations,
					'roles' => $roles,
					'dataProvider' => $dataProvider,
					'operation_add_error' => $authItemObj->errors,
	
				]);
			}else
				 return $this->redirect(['rights']);
		}
		// Add operation child
		if(!empty($_POST['operation_child_auth_item'])){
			$authItemChildObj  = new AuthItemChild;
			
			$authItemChildObj->parent = urldecode($_GET['operation_id']);
			$authItemChildObj->child = urldecode($_POST['operation_child_auth_item']);
			$authItemChildObj->save();
			///var_dump($authItemChildObj->errors);
			if(count($authItemChildObj->errors)>0){
				return $this->render('rights', [
					'users' => $users,
					'authItems' => $authItems,
					'operations' => $operations,
					'roles' => $roles,
					'dataProvider' => $dataProvider,
					'operationChild_assigment_error' => $authItemChildObj->errors,
	
				]);
			}else
				 return $this->redirect(['rights','operation_id'=>$_GET['operation_id']]);
		}
			if(!empty($_GET['operation_del'])){
				
				//print_r(urldecode($_GET['operation_del']));
				//exit;
				
				$authItemObj  = AuthItem::find()->where("name='".urldecode($_GET['operation_del'])."'")->one();
				
				$authItemObj->delete();

				return $this->redirect(['rights']);
				
			}
			if(!empty($_GET['role_del'])){
			//print_r($_GET[role_del]);
			//exit;
				$authItemObj  = AuthItem::find()->where("name='".urldecode($_GET['role_del'])."'")->one();
				
				$authItemObj->delete();
				return $this->redirect(['rights']);
			}
			return $this->render('rights', [
					'users' => $users,
					'authItems' => $authItems,
					'operations' => $operations,
					'roles' => $roles,
					//'dataProvider' => $dataProvider,
					//'searchModel' => $searchModel,
				]);
		
	}
}
