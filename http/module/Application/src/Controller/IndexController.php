<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 *
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use MongoDB\Collection;
use MongoDB\Client;
use Application\Form\SearchForm;
use Application\Model\Search;

class IndexController extends AbstractActionController
{
    const DB_NAME       = 'mongodb';
    const COLLECTION    = 'pages';

    public function indexAction()
    {
        $this->layout('layout/search');
        $form   = new SearchForm();
        $search = new Search();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($search->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $search->exchangeArray($form->getData());

                return $this->redirect()->toRoute(
                    'application',
                    [
                        'action' => 'result',
                        'query'  => $search->getQuery(),
                    ]
                );
            } else {
                $errors = $form->getMessages();

                return new ViewModel(
                    [
                        'form'   => $form,
                        'errors' => $errors,
                    ]
                );
            }
        }

        return new ViewModel(
            [
                'form' => $form,
            ]
        );
    }

    public function resultAction()
    {
        $this->layout('layout/result');
        $query = $this->params()->fromRoute('query', '');

        $client = new Client();
        $coll   = $client->selectCollection(self::DB_NAME, self::COLLECTION);

        $results = $coll->aggregate(
            [
                [
                    //Search for all occurences, which are similar to the query
                    '$match' =>
                    [
                        '$text' => ['$search' => $query],
                    ],
                ],
                [
                    //Only take the fields, we are interested in
                    '$project' =>
                    [
                        '_id'     => 0,
                        'content' =>
                        [
                            //Only take the first 50 characters of the
                            //content for display purposes
                            '$substr' => ['$content', 0, 50],
                        ],
                        'pr'      => 1,
                        'url'     => 1,
                        'title'   => 1,
                        'score'   => ['$meta' => 'textScore'],
                    ],
                ],
                [
                    //Sort by matching to the query first and PR second.
                    //Both in descending order
                    '$sort' =>
                    [
                        'score' => -1,
                        'pr'    => -1,
                    ],
                ],
            ]
        );

        $form   = new SearchForm();

        return new ViewModel(
            [
                'query'   => $query,
                'results' => $results,
                'form'    => $form,
            ]
        );
    }
}
