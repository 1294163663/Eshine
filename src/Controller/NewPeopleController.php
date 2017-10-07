<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/7
 * Time: 12:53
 */

namespace EShine\Controller;

use EShine\Model\NewPeopleModel;
use Slim\Http\Request;
use Slim\Http\Response;

require __DIR__ . '/../../vendor/autoload.php';

class NewPeopleController extends BaseController
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args array
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        // TODO: Implement __invoke() method.
    }

    public function show(Request $request, Response $response, array $args)
    {
        return $this->renderer->render($response, 'index.html', $args);
    }


    public function getApplyStatus(Request $request, Response $response, array $args)
    {
        $params = $request->getParams();
        if (empty($params['name']) || empty($params['phone'])) {
            throw new \Exception("查询所需信息不足");
        }
        $people = new NewPeopleModel(['name'=>$params['name'], 'phone'=>$params['phone']]);
        $result = $people->find();
        $args['result'] = $result;
        return $this->renderer->render($response, 'index.html', $args);
    }

    public function newApply(Request $request, Response $response, array $args)
    {
        $params = $request->getParams();
        if (empty($params['name']) || empty($params['phone'])) {
            throw new \Exception("信息不足");
        }
        $people = new NewPeopleModel($params);
        $people->save();

        return $response->withRedirect($this->router->pathFor('query',['name'=>$params['name'], 'phone'=>$params['phone']]));
    }

    public function getNewPeopleExcel(Request $request, Response $response, array $args)
    {
        $people = new NewPeopleModel();
        $people->excelOut();
    }
}