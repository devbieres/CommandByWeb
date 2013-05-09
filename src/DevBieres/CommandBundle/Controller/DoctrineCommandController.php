<?php
namespace DevBieres\CommandBundle\Controller;
/*
 * ----------------------------------------------------------------------------
 * « LICENCE BEERWARE » (Révision 42):
 * <devbieres@lafamillebn.net> a créé ce fichier. Tant que vous conservez cet avertissement,
 * vous pouvez faire ce que vous voulez de ce truc. Si on se rencontre un jour et
 * que vous pensez que ce truc vaut le coup, vous pouvez me payer une bière en
 * retour. 
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <devbieres@lafamillebn.net> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. 
 * ----------------------------------------------------------------------------
 * Plus d'infos : http://fr.wikipedia.org/wiki/Beerware
 * ----------------------------------------------------------------------------
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use DevBieres\CommandBundle\Entity\ArrayOutput;
use Symfony\Component\HttpFoundation\Request;

/**
 * Some doctrine command
 */
class DoctrineCommandController extends BaseCommandController {

		/**
		 * Execute the doctrine:schema:create
		 * @param Request $request
		 */
		public function DoctrineSchemaCreateAction(Request $request) {
				// Infos
				$command = "doctrine:schema:create";
				$path    = "doctrine_schema_create";

				// Data definition
				$data = array('env' => 'dev', 'dumpsql' => false);

				// Form Building 
				$form = $this->createFormBuilder($data)
						->add('env', 'choice',
								array(
										'choices' => array('dev' => 'dev', 'test' => 'test', 'prod' => 'prod'),
										'required' => true
								)
						)
						->add('dumpsql', 'checkbox', array('required' => false))
						->getForm();

				// Post
				if($request->isMethod('POST')) {
						// Binding the form and getting the data
						$form->bind($request);
						$data = $form->getData();
						// Setting the params
						$params = array(
								"--dump-sql" => $data["dumpsql"],
								"--env"      => $data["env"]
						);
				} else {
						// By defaults : help
				       $params = array('--help' => true);
				} 	

				// Execution
				$messages = $this->runCommand($command, $params);

				// Rendering
				return $this->renderFormMessages($command, $params, $messages, $form, $path);

		} /* /DoctrineSchemaCreateAction */

		/**
		 * Execute the doctrine:schema:update command
		 * @param Request $request
		 */
		public function DoctrineSchemaUpdateAction(Request $request) {
				// Info
				$command = "doctrine:schema:update";
				$path = "doctrine_schema_update";

				// Data definition
				$data = array('mode' => 'dumpsql', 'complete' => false, 'env' => 'dev');

				// Form building 
				$form = $this->createFormBuilder($data)
						->add('mode', 'choice',
								array(
										'choices' => array('dumpsql' => '--dump-sql', 'force' => '--force'),
								        'required' => true
								)
						)
						->add('complete', 'checkbox', array('required' => false))
						->add('env', 'choice',
								array(
										'choices' => array('dev' => 'dev', 'test' => 'test', 'prod' => 'prod'),
										'required' => true
								)
						)
						->getForm();
                
				// POST
				if($request->isMethod('POST')) { 
						// Binding the form and getting the data
						$form->bind($request);
						$data = $form->getData();
						// Setting the params 
						$params = array(
								"--dump-sql" => ($data["mode"]=="dumpsql") ? true : false,
								"--force"    => ($data["mode"]=="force")   ? true : false,
								"--complete" => $data["complete"],
								"--env"      => $data["env"]
						);
				} else {
						// By defaults : help
				   $params = array('--help' => true);
				} 	

				// Execution
				$messages = $this->runCommand($command, $params);

				// Rendering
				return $this->renderFormMessages($command, $params, $messages, $form, $path);

		} // /DoctrineSchemaUpdateAction

		/**
		 * Execute the doctrine:schema:drop command
		 * @param Request $request
		 */
		public function DoctrineSchemaDropAction(Request $request) {
				// Infos
				$command = "doctrine:schema:drop";
				$path    = "doctrine_schema_drop";

				// Data definition
				$data = array('env' => 'dev', 'full' => false);

				// Form building
				$form = $this->createFormBuilder($data)
						->add('mode', 'choice',
								array(
										'choices' => array('dumpsql' => '--dump-sql', 'force' => '--force'),
								        'required' => true
								)
						)
						->add('env', 'choice',
								array(
										'choices' => array('dev' => 'dev', 'test' => 'test', 'prod' => 'prod'),
										'required' => true
								)
						)
						->add('full', 'checkbox', array('required' => false))
						->getForm();

				// POST
				if($request->isMethod('POST')) {
						// Binding the form and getting the data
						$form->bind($request);
						$data = $form->getData();
						// Setting the params
						$params = array(
								"--dump-sql"         => ($data["mode"]=="dumpsql") ? true : false,
								"--force"            => ($data["mode"]=="force")   ? true : false,
								"--full-database"    => $data["full"],
								"--env"              => $data["env"]
						);
				} else {
						// By defaults : help
				       $params = array('--help' => true);
				} 	

				// Execution
				$messages = $this->runCommand($command, $params);

				// Rendering
				return $this->renderFormMessages($command, $params, $messages, $form, $path);
		} /* /DoctrineSchemaDropAction */

		/**
		 * Call the doctrine:schema:validate command 
		 * @param Request $request
		 */
		public function DoctrineSchemaValidateAction(Request $request) {
				// Infos
				$command = "doctrine:schema:validate";
				$path    = "doctrine_schema_validate";

				// Data definition
				$data = array('env' => 'dev');

				// Form building
				$form = $this->createFormBuilder($data)
						->add('env', 'choice',
								array(
										'choices' => array('dev' => 'dev', 'test' => 'test', 'prod' => 'prod'),
										'required' => true
								)
						)
						->getForm();

				// POST
				if($request->isMethod('POST')) {
						// Binding the form and getting the data
						$form->bind($request);
						$data = $form->getData();
						// Setting the params
						$params = array(
								"--env"      => $data["env"]
						);
				} else {
						// By defaults : help
				       $params = array('--help' => true);
				} 	

				// Execution
				$messages = $this->runCommand($command, $params);

				// Rendering
				return $this->renderFormMessages($command, $params, $messages, $form, $path);
		} /* /DoctrineSchemaValidate */

}
