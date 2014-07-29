<?php
    //require_once 'DispositivosController.php';
    class EmpresasControllerTest extends ControllerTestCase {
        public $fixtures = array('app.empresa','app.configuracion','app.consejo','app.users');
        //public $components = array('Session', 'RequestHandler', 'Cookie', ...);



        public function testView() {
            //Test empresa existente
            $result = $this->testAction('/empresas/view/113');
            debug($result);
            //Tets empresa inexistente
            $result = $this->testAction('/empresas/view/200');
            debug($result);
            //Test empresa con falta de datos
            $result = $this->testAction('/empresas/view/116');
            debug($result);
        }

        public function testSelectEmpresa(){
            /*$Posts = $this->generate('Posts', array(
                'methods' => array(
                    'isAuthorized'
                ),
                'models' => array(
                    'Post' => array('save')
                ),
                'components' => array(
                    'RequestHandler' => array('isPut'),
                    'Email' => array('send'),
                    'Session'
                )
            ));*/
            
            /*$this->Session->write('Test.tech_cookie_name', 'tech_cookie_name');

            $Usuario = array(
                'id' => 214,
                'username' => 'morenox24@gmail.com',
                'password' => '7dd2f8b16129b070eaa8e0463e9432b643684dde',
                'normas' => 1,
                'nivel' => 0,
                'timestampCreacion' => '2013-05-07 10:03:00',
                'timestampLAcceso' => '2014-05-08 11:03:25',
                'hashString' => 'a694f12687453ba42b3480a7eaaf66b694ca7b59',
                'welcome' => 1
            );*/
            /*$this->Users = $this->generate('Users', array(
                'components' => array('
                    Session', 'Auth' => array('
                        User') 
                    )    
                )
            );*/ 

            $this->controller->Auth->expects($this->once())->method('User') 
            //The method user()->with('id') 
            //Will be called with first param 'id' ->will($this->returnValue(2)) 
            //And will return something for me 
            //$this->testAction('/users/edit/2', array('method' => 'get')); 

            //$this->Users->User->expects($this->once())->with('save')->will($this->returnValue(true)); 
            //$this->testAction('/signup', array('data' => $data)); 

            $this->Users = $this->generate('Users', array( 
                'components' => array('Session', 'Auth' => array('User')) 
                'models' => 'Users' 
            )); 

            //Test base
            $result = $this->testAction('/empresas/selectEmpresa');
            //$this->assertInternalType('User', $Usuario);
            debug($result);
        }

        public function testPanel(){
            /*
            //Test empresa existente
            $result = $this->testAction('/empresas/panel/113');
            debug($result);
            //Tets empresa inexistente
            $result = $this->testAction('/empresas/panel/200');
            debug($result);
            //Test empresa con falta de datos
            $result = $this->testAction('/empresas/panel/116');
            debug($result);
            */
        }

        /*public function testIndexShort() {
            $result = $this->testAction('/articles/index/short');
            debug($result);
        }

        public function testIndexShortGetRenderedHtml() {
            $result = $this->testAction(
               '/articles/index/short',
                array('return' => 'contents')
            );
            debug($result);
        }

        public function testIndexShortGetViewVars() {
            $result = $this->testAction(
                '/articles/index/short',
                array('return' => 'vars')
            );
            debug($result);
        }

        public function testIndexPostData() {
            $data = array(
                'Article' => array(
                    'user_id' => 1,
                    'published' => 1,
                    'slug' => 'new-article',
                    'title' => 'New Article',
                    'body' => 'New Body'
                )
            );
            $result = $this->testAction(
                '/articles/index',
                array('data' => $data, 'method' => 'post')
            );
            debug($result);
        }*/
    }
?>