<?php

namespace Cogipix\CogimixCustomProviderBundle\Controller;

use Cogipix\CogimixCustomProviderBundle\Entity\CustomProviderInfo;

use Cogipix\CogimixCustomProviderBundle\Form\CustomProviderInfoEditFormType;

use Cogipix\CogimixCustomProviderBundle\Form\CustomProviderInfoFormType;

use Cogipix\CogimixCommonBundle\Utils\AjaxResult;

use Symfony\Component\HttpFoundation\Request;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
/**
 * @Route("/customProvider")
 * @author plfort - Cogipix
 *
 */
class DefaultController extends Controller
{

    /**
     *  @Secure(roles="ROLE_USER")
     *  @Route("/manageModal",name="_customprovider_manage_modal",options={"expose"=true})
     */
    public function getManageModalAction(Request $request){
        $response = new AjaxResult();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $customProviderInfos=$em->getRepository('CogimixCustomProviderBundle:CustomProviderInfo')->findByUser($user);
        $response->setSuccess(true);
        $response->addData('modalContent', $this->renderView('CogimixCustomProviderBundle:CustomProviderInfo:modalContent.html.twig',array('customProviderInfos'=>$customProviderInfos)));
        return $response->createResponse();
    }
    /**
     *  @Secure(roles="ROLE_USER")
     *  @Route("/test",name="_customprovider_test",options={"expose"=true})
     */
    public function testCustomProviderInfoAction(Request $request){
        $response = new AjaxResult();

        $customProviderInfo = new CustomProviderInfo();
        $form = $this->createForm(new CustomProviderInfoEditFormType(),$customProviderInfo);
        $params= $request->request->get('custom_provider_create_form');
        if(isset($params['alias'])){
            unset($params['alias']);
            $request->request->set('custom_provider_create_form', $params);
        }
        if($request->getMethod()==='POST'){
            $form->bind($request);
            if($form->isValid()){

               $plugin= $this->get('cogimix.custom_provider_plugin_factory')->createCustomProviderPlugin($customProviderInfo);
                if(($responsePlugin = $plugin->testRemote()) !==false){
                    $response->setSuccess(true);
                    $response->addData('message', $responsePlugin['count'].' songs found');
                }else{
                    $response->setSuccess(false);
                    $response->addData('message', "Can't acces the remote provider.");
                }


            }else{

                $response->setSuccess(false);
                $response->addData('message', "Errors in form");
            }
        }
        return $response->createResponse();
       }

    /**
     *  @Secure(roles="ROLE_USER")
     *  @Route("/create",name="_customprovider_create",options={"expose"=true})
     */
    public function createCustomProviderInfoAction(Request $request){
        $response = new AjaxResult();
       $actionUrl = $this->generateUrl('_customprovider_create');
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $customProviderInfo = new CustomProviderInfo();

        $customProviderInfo->setUser($user);
        $action ='create';
            $response->addData('formType', $action);

            $form = $this->createForm(new CustomProviderInfoFormType(),$customProviderInfo);
            if($request->getMethod()==='POST'){
                $form->bind($request);
                if($form->isValid()){
                    $em->persist($customProviderInfo);
                    $em->flush();
                    $response->setSuccess(true);
                    $response->addData('newItem', $this->renderView('CogimixCustomProviderBundle:CustomProviderInfo:listItem.html.twig',array('customProviderInfo'=>$customProviderInfo)));
                }else{
                    $response->setSuccess(false);
                    $response->addData('formHtml', $this->renderView('CogimixCustomProviderBundle:CustomProviderInfo:formContent.html.twig',array('action'=>$action,'actionUrl'=>$actionUrl, 'customProviderInfo'=>$customProviderInfo,'form'=>$form->createView())));
                }
            }else{
                $response->setSuccess(true);
                $response->addData('formHtml', $this->renderView('CogimixCustomProviderBundle:CustomProviderInfo:formContent.html.twig',array('action'=>$action, 'actionUrl'=>$actionUrl,'customProviderInfo'=>$customProviderInfo,'form'=>$form->createView())));
            }



        return $response->createResponse();
    }

    /**
     *  @Secure(roles="ROLE_USER")
     *  @Route("/edit/{id}",name="_customprovider_edit",options={"expose"=true})
     */
    public function editCustomProviderInfoAction(Request $request,$id){
        $response = new AjaxResult();

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $customProviderInfo=$em->getRepository('CogimixCustomProviderBundle:CustomProviderInfo')->findOneById($id);
        if($customProviderInfo!==null && $customProviderInfo->getUser()==$user){
            $actionUrl = $this->generateUrl('_customprovider_edit',array('id'=>$id));
            $action='edit';
            $response->addData('formType',$action);
            $form = $this->createForm(new CustomProviderInfoEditFormType(),$customProviderInfo);

            if($request->getMethod()==='POST'){
                $form->bind($request);
                if($form->isValid()){
                        $em->flush();
                        $response->setSuccess(true);
                        //return $response->createResponse();
                }else{

                    $response->setSuccess(false);
                    $response->addData('formHtml', $this->renderView('CogimixCustomProviderBundle:CustomProviderInfo:formContent.html.twig',array('action'=>$action,'actionUrl'=>$actionUrl,'customProviderInfo'=>$customProviderInfo,'form'=>$form->createView())));
                }
            }else{
                $response->setSuccess(true);
                $response->addData('formHtml', $this->renderView('CogimixCustomProviderBundle:CustomProviderInfo:formContent.html.twig',array('action'=>$action,'actionUrl'=>$actionUrl,'customProviderInfo'=>$customProviderInfo,'form'=>$form->createView())));
            }
       }


        return $response->createResponse();
    }
    /**
     *  @Secure(roles="ROLE_USER")
     *  @Route("/remove/{id}",name="_customprovider_remove",options={"expose"=true})
     */
    public function removeCustomProviderInfoAction(Request $request, $id){
        $response = new AjaxResult();

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $customProviderInfo=$em->getRepository('CogimixCustomProviderBundle:CustomProviderInfo')->findOneById($id);
        if($customProviderInfo!==null && $customProviderInfo->getUser()==$user){
            $em->remove($customProviderInfo);
            $em->flush();
            $response->setSuccess(true);
            $response->addData('id', $id);
        }

        return $response->createResponse();
    }

}
