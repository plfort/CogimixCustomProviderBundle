<?php

namespace Cogipix\CogimixCustomProviderBundle\Controller;

use Cogipix\CogimixCustomProviderBundle\Entity\CustomProviderInfo;

use Cogipix\CogimixCustomProviderBundle\Form\CustomProviderInfoEditFormType;

use Cogipix\CogimixCustomProviderBundle\Form\CustomProviderInfoFormType;

use Cogipix\CogimixBundle\Utils\AjaxResult;

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
        $user = $this->getCurrentUser();
        $em = $this->getDoctrine()->getEntityManager();
        $customProviderInfos=$em->getRepository('CogimixCustomProviderBundle:CustomProviderInfo')->findByUser($user);
        $response->setSuccess(true);
        $response->addData('modalContent', $this->renderView('CogimixCustomProviderBundle:CustomProviderInfo:modalContent.html.twig',array('customProviderInfos'=>$customProviderInfos)));
        return $response->createResponse();
    }

    /**
     *  @Secure(roles="ROLE_USER")
     *  @Route("/create",name="_customprovider_create",options={"expose"=true})
     */
    public function createCustomProviderInfoAction(Request $request){
        $response = new AjaxResult();
       $actionUrl = $this->generateUrl('_customprovider_create');
        $user = $this->getCurrentUser();
        $em = $this->getDoctrine()->getEntityManager();
        $customProviderInfo = new CustomProviderInfo();

        $customProviderInfo->setUser($user);
            $response->addData('formType', 'create');
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
                    $response->addData('formHtml', $this->renderView('CogimixCustomProviderBundle:CustomProviderInfo:formContent.html.twig',array('actionUrl'=>$actionUrl, 'customProviderInfo'=>$customProviderInfo,'form'=>$form->createView())));
                }
            }else{
                $response->setSuccess(true);
                $response->addData('formHtml', $this->renderView('CogimixCustomProviderBundle:CustomProviderInfo:formContent.html.twig',array('actionUrl'=>$actionUrl,'customProviderInfo'=>$customProviderInfo,'form'=>$form->createView())));
            }



        return $response->createResponse();
    }

    /**
     *  @Secure(roles="ROLE_USER")
     *  @Route("/edit/{id}",name="_customprovider_edit",options={"expose"=true})
     */
    public function editCustomProviderInfoAction(Request $request,$id){
        $response = new AjaxResult();

        $user = $this->getCurrentUser();
        $em = $this->getDoctrine()->getEntityManager();
        $customProviderInfo=$em->getRepository('CogimixCustomProviderBundle:CustomProviderInfo')->findOneById($id);
        if($customProviderInfo!==null){
            $actionUrl = $this->generateUrl('_customprovider_edit',array('id'=>$id));
            $response->addData('formType', 'edit');
            $form = $this->createForm(new CustomProviderInfoEditFormType(),$customProviderInfo);
            if($request->getMethod()==='POST'){
                $form->bind($request);
                if($form->isValid()){
                        $em->flush();
                        $response->setSuccess(true);
                        //return $response->createResponse();
                }else{
                    $response->setSuccess(false);
                    $response->addData('formHtml', $this->renderView('CogimixCustomProviderBundle:CustomProviderInfo:formContent.html.twig',array('actionUrl'=>$actionUrl,'customProviderInfo'=>$customProviderInfo,'form'=>$form->createView())));
                }
            }else{
                $response->setSuccess(true);
                $response->addData('formHtml', $this->renderView('CogimixCustomProviderBundle:CustomProviderInfo:formContent.html.twig',array('actionUrl'=>$actionUrl,'customProviderInfo'=>$customProviderInfo,'form'=>$form->createView())));
            }
       }


        return $response->createResponse();
    }

    private function getCurrentUser() {
        $user = $this->get('security.context')->getToken()->getUser();
        if ($user instanceof \FOS\UserBundle\Model\UserInterface)
            return $user;
        return null;
    }
}
