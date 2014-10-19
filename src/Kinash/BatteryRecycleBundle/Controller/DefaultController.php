<?php

namespace Kinash\BatteryRecycleBundle\Controller;

use Kinash\BatteryRecycleBundle\Entity\BatteryPack;
use Kinash\BatteryRecycleBundle\Form\BatteryPackType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * HomePage of Application
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $list = $this->getDoctrine()->getManager()->getRepository('BatteryRecycleBundle:BatteryPack')->calculateBatteries();
        return $this->render('BatteryRecycleBundle:Default:index.html.twig', array('list' => $list));
    }

    /** Page for add new Pack
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $type = new BatteryPackType();
        $form = $this->createForm($type);
        $form->handleRequest($request);
        if($form->isValid()){
           $this->_saveForm($form);
           return $this->redirect($this->generateUrl('battery_recycle_homepage'));
        }
        return $this->render('BatteryRecycleBundle:Default:new.html.twig', array('form' => $form->createView()));
    }

    /** Save data from form
     * @param $form
     */
    protected function _saveForm($form){
        $em = $this->getDoctrine()->getManager();
        $batteryPack = $form->getData();
        $em->persist($batteryPack);
        $em->flush();
    }
}
