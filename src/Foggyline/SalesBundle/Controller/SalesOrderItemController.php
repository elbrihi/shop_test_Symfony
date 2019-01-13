<?php

namespace Foggyline\SalesBundle\Controller;

use Foggyline\SalesBundle\Entity\SalesOrderItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Salesorderitem controller.
 *
 * @Route("salesorderitem")
 */
class SalesOrderItemController extends Controller
{
    /**
     * Lists all salesOrderItem entities.
     *
     * @Route("/", name="salesorderitem_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $salesOrderItems = $em->getRepository('FoggylineSalesBundle:SalesOrderItem')->findAll();

        return $this->render('salesorderitem/index.html.twig', array(
            'salesOrderItems' => $salesOrderItems,
        ));
    }

    /**
     * Creates a new salesOrderItem entity.
     *
     * @Route("/new", name="salesorderitem_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $salesOrderItem = new Salesorderitem();
        $form = $this->createForm('Foggyline\SalesBundle\Form\SalesOrderItemType', $salesOrderItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($salesOrderItem);
            $em->flush();

            return $this->redirectToRoute('salesorderitem_show', array('id' => $salesOrderItem->getId()));
        }

        return $this->render('salesorderitem/new.html.twig', array(
            'salesOrderItem' => $salesOrderItem,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a salesOrderItem entity.
     *
     * @Route("/{id}", name="salesorderitem_show")
     * @Method("GET")
     */
    public function showAction(SalesOrderItem $salesOrderItem)
    {
        $deleteForm = $this->createDeleteForm($salesOrderItem);

        return $this->render('salesorderitem/show.html.twig', array(
            'salesOrderItem' => $salesOrderItem,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing salesOrderItem entity.
     *
     * @Route("/{id}/edit", name="salesorderitem_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SalesOrderItem $salesOrderItem)
    {
        $deleteForm = $this->createDeleteForm($salesOrderItem);
        $editForm = $this->createForm('Foggyline\SalesBundle\Form\SalesOrderItemType', $salesOrderItem);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('salesorderitem_edit', array('id' => $salesOrderItem->getId()));
        }

        return $this->render('salesorderitem/edit.html.twig', array(
            'salesOrderItem' => $salesOrderItem,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a salesOrderItem entity.
     *
     * @Route("/{id}", name="salesorderitem_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SalesOrderItem $salesOrderItem)
    {
        $form = $this->createDeleteForm($salesOrderItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($salesOrderItem);
            $em->flush();
        }

        return $this->redirectToRoute('salesorderitem_index');
    }

    /**
     * Creates a form to delete a salesOrderItem entity.
     *
     * @param SalesOrderItem $salesOrderItem The salesOrderItem entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SalesOrderItem $salesOrderItem)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('salesorderitem_delete', array('id' => $salesOrderItem->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
