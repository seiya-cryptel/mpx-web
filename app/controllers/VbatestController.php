<?php

class VBATestController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->disable();
        
          if(! $this->request->isPost()) {
              $res = json_encode(array(
                  'Res' => 'Error',
                  'Detail' => 'No data posted',
              ));
          }
          else {
              $post = $this->request->getPost();
              if(empty($post['id']) || empty($post['pwd'])) {
                $res = json_encode(array(
                    'Res' => 'Error',
                    'Detail' => 'ID and/or Password are missing',
                ));
            }
            else {
                $user = Users::findFirst(
                                array(
                                    "(isvalid=1) AND (id = :userId:)",
                                    'bind' => array(
                                        'userId' => $post['id'],
                                    )
                                )
                );
                if (($user == false) || (!$this->security->checkHash($post['pwd'], $user->pwd))) {
                    $res = json_encode(array(
                        'Res' => 'Error',
                        'Detail' => 'Valid user is not found',
                    ));
                }
                else {
                    $users = Users::find();
                    $resData = array();
                    foreach($users as $user) {
                        $resData[] = array(
                            'id' => $user['user_id'],
                            'name' => $user['user_name'],
                            'type' => $user['user_type_disp'],
                        );
                    }
                    $res = json_encode(array(
                        'Res' => 'OK',
                        'Detail' => count($users),
                        'Data' => array(
                            'user_id' => $resData
                        ),
                    ));
                }
            }
        }
        $len = strlen($res);
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/javascript");
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setContent($res);
        $response->send();
    }

}
