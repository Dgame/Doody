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
use Application\Form\SearchForm;
use Application\Model\Search;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/search');
        $form = new SearchForm();
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
                        'query' => $search->getQuery(),
                    ]
                );
            } else {
                $errors = $form->getMessages();

                return new ViewModel(
                    [
                        'form' => $form,
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
        
        //Mongokram Abfragen
        return new ViewModel();
    }
}
