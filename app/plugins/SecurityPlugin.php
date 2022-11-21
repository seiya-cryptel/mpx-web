<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin {

    // ユーザ種別 2015/12/10
    const ROLE_ADMIN = 9;
    const ROLE_USER_HR = 2;
    const ROLE_USER_LR = 1;

    /**
     * Returns an existing or new access control list
     *
     * @returns AclList
     */
    public function getAcl() {
        if (!isset($this->persistent->acl)) {

            $acl = new AclList();
            $acl->setDefaultAction(Acl::DENY);

            //Register roles
            $roles = array(
                'admins' => new Role('Admins'), // 管理者
                'users' => new Role('Users'), // 管理者ではないログイン権限を持つユーザ
                'guests' => new Role('Guests') // 管理者ではないログイン権限を持たないユーザ
            );
            foreach ($roles as $role) {
                $acl->addRole($role);
            }

            /* 追加 */
            // Administrative area resources
            $adminResources = array(
                'upload' => array(
                    'index', 'forwardPower', 
                    'forwardFuel', 
                    'forwardFuelCIF', 
                    'jepx', 'cme', 'prerequisite', 'historicaldemand', 'capacity', 'upload', 'graphData', 'any'
                    ), // 2016/01/15
                // 'background' => array('index'), // 背景と弊社の取り組み
                // 'aboutforwardcurve' => array('index'), // 電力フォワードカーブについて
                'methodology' => array('index'), // メソドロジー
                // 'service' => array('index'), // サービスメニューと料金体系
                'management' => array(// 管理画面
                    'index', // ユーザ
                    'useradd',
                    'useredit',
                    'usersave',
                    'usercreate',
                    'userprofile',
                    'accesslog', // アクセスログ
                    'datalist', // 格納データ
                    'news',
                    'newspost',
                    'newsedit',
                    'newscreate',
                    'newssave',
                    'report',
                    'reportpost',
                    'reportcreate',
                    'upload',
                    'updatedmail',      // 2017/05/12
                ), // 管理画面
            );
            foreach ($adminResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }

            //Private area resources
            $privateResources = array(
                'computationallogic' => array('index'),
                'forwardcurve' => array(
                    'index',
                    'eastprice',
                    'westprice',
                    'hprice',       // 2016/02/17
                    'kprice',
                    'threeprice',
                    'fiveprice',    // 2017/04/07
                    'e',            // 2020/01/31
                    'eastpricee',
                    'westpricee',
                    'hpricee',
                    'kpricee',
                    'fivepricee',
                ),
                // 2016/07/06
                'jepxfc' => array(
                    'index',
                    'eastprice',
                    'westprice',
                    'threeprice',
                    'hprice',       // 2016/02/17
                    'kprice',
                    'fiveprice',
                    'e',            // 2020/01/31
                    'eastpricee',
                    'westpricee',
                    'hpricee',
                    'kpricee',
                    'fivepricee',
                ),
                'dsprice' => array( // 2019/10/31
                    'index',
                    'e',
                    'w',
                    'h',
                    'k',
                    // 2020/01/31
                    'en',
                    'ee',
                    'we',
                    'he',
                    'ke',
                    // 2020/02/21
                    'rem',
                    'reme',
                ),
                'historicaldata' => array('index'),
                // 'inquiry' => array('index'),
                'inquiry' => array('index', 'e'),
                // 'index' => array('index'),
                // 'login' => array('index', 'lostpwd'),
                // 前提条件
                'prerequisite' => array(
                    'index', // JEPX
                    'fuelandexchange', // 燃料・為替先物
                    'demandandrenewableenergy', // 需要・再エネ想定
                    'demandandrenewableenergyeast', // 需要・再エネ想定 東エリア
                    'demandandrenewableenergywest', // 需要・再エネ想定 西エリア
                    'demandandrenewableenergyh',    // 需要・再エネ想定 北海道 2017/02/20
                    'demandandrenewableenergyk',    // 需要・再エネ想定 九州
                    'fuel', // 燃料価格想定
                    'fuelcif',  // 2019/02/08燃料CIF価格想定
                    'capacity', // 供給力想定
                    'capacityeast', // 供給力想定 東エリア
                    'capacitywest', // 供給力想定 西エリア
                    'capacityhokkaido', // 供給力想定 北海道
                    'capacitykyushu', // 供給力想定 九州
                    'historicaldemand', // 需要実績
                    'historicaldemandeast', // 需要実績 東エリア
                    'historicaldemandwest', // 需要実績 西エリア
                    'interconnect', // 連系線潮流
                    'interconnectkitahon',      // 2017/02/23
                    'interconnectkanmon',
                    'deliverymonthly', // 受渡月別価格推移  
                    'deliverymonthlydistribution', // 受渡月別価格分布
                    'nuclearsupply', // 原子力供給
                    'shortjepx', // JEPXスポット短期予想
                    // 2020/01/31
                    'en', // JEPX
                    'fuelandexchangee', // 燃料・為替先物
                    'demandandrenewableenergye', // 需要・再エネ想定
                    'demandandrenewableenergyeaste', // 需要・再エネ想定 東エリア
                    'demandandrenewableenergyweste', // 需要・再エネ想定 西エリア
                    'demandandrenewableenergyhe',    // 需要・再エネ想定 北海道 2017/02/20
                    'demandandrenewableenergyke',    // 需要・再エネ想定 九州
                    'fuele', // 燃料価格想定
                    'fuelcife',  // 2019/02/08燃料CIF価格想定
                    'capacitye', // 供給力想定
                    'capacityeaste', // 供給力想定 東エリア
                    'capacityweste', // 供給力想定 西エリア
                    'capacityhokkaidoe', // 供給力想定 北海道
                    'capacitykyushue', // 供給力想定 九州
                    'historicaldemande', // 需要実績
                    'historicaldemandeaste', // 需要実績 東エリア
                    'historicaldemandweste', // 需要実績 西エリア
                    'interconnecte', // 連系線潮流
                    'interconnectkitahone',      // 2017/02/23
                    'interconnectkanmone',
                    'deliverymonthlye', // 受渡月別価格推移  
                    'deliverymonthlydistributione', // 受渡月別価格分布
                    'nuclearsupplye', // 原子力供給
                    'shortjepxe', // JEPXスポット短期予想
                ),
                'session' => array('logout'),
                // 'users' => array('profile', 'setpwd'),
                'users' => array('profile', 'setpwd', 'profilee', 'setpwde'),   // 2020/01/31
                // コンセプト
                // 'computationallogic' => array('index'),
                // 'sample' => array('index'),
                // 'background' => array('index'), // 背景と弊社の取り組み
                // 'aboutforwardcurve' => array('index'), // 電力フォワードカーブについて
                'methodology' => array('index'), // メソドロジー
                // 'service' => array('index'), // サービスメニューと料金体系
                'report' => array('m', 'fc', 'gs', 'va', 'rp', 'o'), // レポート PDF 2018/04/27; 2017/11/15; 2017/07/12
                // 'news' => array('m', 'w', 'fc', 'gs', 'va', 'rp', 'o'), // レポート一覧 2018/04/27; 2017/11/15; 2017/07/12
                'news' => [
                    'm', 'w', 'fc', 'gs', 'va', 'rp', 'o',
                    'me', 'we', 'fce', 'gse', 'vae', 'rpe', 'oe',   // 今日
                    ],  // 2020/01/31
                // 'clause' => array('index'),     // 2016/03/28
                // 'mpx' => array('index'),        // 2016/03/28
                'tool' => array(                    // 2017/05/21
                    'index',
                    'dl',
                    'flist',            // 2017/08/03
                    'df',
                    'db',       // 2018/03/11
                    'en',       // 2020/01/31
                    'dle',
                    'fliste',
                    'dfe',
                    'dbe',
                    ),
                'download' => array(    // 2017/07/04
                    'dlzip',
                ),
                'asp' => array(    // 2018/02/16
                    'index',
                    'top',
                    'up',
                    'folder',
                    'file',
                    // 2020/01/31
                    'en',
                    'tope',
                    'upe',
                    'foldere',
                ),
            );
            foreach ($privateResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }

            //Public area resources
            $publicResources = array(
                // 'forwardcurve' => array('index'),
                // 'historicaldata' => array('index'),
                // 'index' => array('index'),
                'index' => ['index', 'e'],      // 2020/01/28
                // 'login' => array('index', 'lostpwd'),
                'login' => ['index', 'lostpwd', 'e', 'lostpwde'],   // 2020/01/29
                // 'inquiry' => array('guest'), // お問い合わせ
                'inquiry' => ['guest', 'gueste'],   // 2020/01/29
                // 'prerequisite' => array('index'),
                'session' => array('start', 'conflict', 'conflicte'),   // 2020/01/31
                'sample' => array('index'),
                // 'background' => array('index'), // 背景と弊社の取り組み
                'background' => ['index', 'e'],     // 2020/01/29
                'aboutforwardcurve' => array('index'), // 電力フォワードカーブについて
                'methodology' => array('index'), // メソドロジー
                'service' => array('index'), // サービスメニューと料金体系
                'termsofuse' => array('index'), // 利用条件
                'report' => array('index', 'w'), // 週次レポート PDF
                // 'news' => array('index', 'w', 'm', 'c'),  // お知らせ 2016/06/20
                'news' => [
                    'index', 'w', 'm', 'c',
                    'en', 'we', 'me', 'ce',     // 2020/01/31
                    ],
                'mpx' => array('index'),        // 2016/03/30
                'clause' => array('index'),
                'download' => array(
                    'index',
                    'ad',       // 2017/05/22
                    ),
            );
            foreach ($publicResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }

            //Grant access to public areas to both users and guests
            foreach ($roles as $role) {
                foreach ($publicResources as $resource => $actions) {
                    foreach ($actions as $action) {
                        $acl->allow($role->getName(), $resource, $action);
                    }
                }
            }

            //Grant acess to private area to role Users
            foreach ($privateResources as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow('Users', $resource, $action);
                    $acl->allow('Admins', $resource, $action);
                }
            }

            //Grant acess to private area to role Admins
            foreach ($adminResources as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow('Admins', $resource, $action);
                }
            }
            //The acl is stored in session, APC would be useful here too
            $this->persistent->acl = $acl;
        }

        return $this->persistent->acl;
    }

    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    // public function beforeDispatch(Event $event, Dispatcher $dispatcher) {   2018/10/15
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher) {
        $MyLog = new MyLogs();  // 2016/01/24
        // $MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__, []);
        // ログインの確認が取れない場合のロールはGuestsです。
        $role = 'Guests';

        // ログイン済なら、セッション変数authに利用者情報配列が設定されています。
        $auth = $this->session->get('auth');
        // 2020/02/11
        $lang = $this->session->has('lang') ? $this->session->get('lang') : 'ja';

        if ($auth) {
            $userId = $auth['user_id'];

            // 利用者IDでセッション管理レコードを探します。
            $session = Session::findFirst(
                            array(
                                'user_id = :user_id:',
                                'bind' => array(
                                    'user_id' => $userId,
                                )
                            )
            );
            $thisId = $this->session->get(SessionController::SV_THISID);
            $savedId = $session ? $session->id : null;
            $MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __FUNCTION__ . ' userId: %s, thisSession: %s, session->id: %s', [$userId, $thisId, $savedId]);

            // セッションがない場合は、ログアウト済み
            if ($session == false) {
                // $this->flash->error($userId . ' はログアウトされました。');  2020/02/12
                $this->flash->error(($lang == 'ja') ? $userId . ' はログアウトされました。' : 'User ' . $userId . ' was logged out.');
                $this->session->remove('auth');
                $this->session->remove(SessionController::SV_THISID);
            }
            // セッション管理レコードに保存されているIDと、セッション変数として覚えている管理IDが異なる場合
            elseif ($savedId != $thisId) {
                // $this->flash->error($userId . ' は他の端末でログインされました。');
                $this->flash->error(($lang == 'ja') ? $userId . ' は他の端末でログインされました。' : 'User ' . $userId . ' has logged in on another PC.');
                $this->session->remove('auth');
                $this->session->remove(SessionController::SV_THISID);
            }
            // 操作のない時間が規定を超えた場合
            elseif (date('Y-m-d H:i:s') > $session->valid_until) {
                // $this->flash->error($userId . ' は一定時間操作がなかったのでログアウトされました。');
                $this->flash->error(($lang == 'ja') ? $userId . ' は一定時間操作がなかったのでログアウトされました。' : 'User ' . $userId . ' has been logged out due to inactivity.');
                $this->session->remove('auth');
                $this->session->remove(SessionController::SV_THISID);
                $session->delete();
            } else {
                $sysSetting = $this->session->get(ControllerBase::SV_VALUES);
                $strValidUntil = date('Y-m-d H:i:s', strtotime('+' . intval($sysSetting['SESSION_VALID_TIME'][0]) . ' minutes'));
                $session->update(['valid_until' => $strValidUntil]);
                // 管理IDが等しいならば、処理を継続します。
                switch ($auth['role']) {
                    case self::ROLE_ADMIN:
                        $role = 'Admins';
                        break;
                    default:
                        $role = 'Users';
                        break;
                }
            }
        }

        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        $acl = $this->getAcl();

        $allowed = $acl->isAllowed($role, $controller, $action);

        $MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_DISPATCH, array($controller, $action, $allowed));

        if ($allowed != Acl::ALLOW) {
            $dispatcher->forward(array(
                'controller' => 'index',
                // 'action' => 'index'  2020/02/28
                'action' => ($lang == 'ja') ? 'index' : 'e',
            ));
            // $this->session->destroy();
            return false;
        }
    }

}
