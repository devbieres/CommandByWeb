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

use DevBieres\CommandBundle\Form\Type\EnvChoiceType;
use DevBieres\CommandBundle\Form\Type\ModeSqlChoiceType;
use DevBieres\CommandBundle\Form\Type\FormatChoiceType;

/**
 * To avoid big controller, they are separated by "domain". So here is a base class
 */
abstract class BaseCommandController extends Controller {

		const WAR_WRITEACCESS = "writeaccess";
		const WAR_RELOAD = "needreload";

		/**
		 * Store a warning
		 * @param string $message will be send to translation
		 */
		protected function storeWarning($message) { 

				$message = $this->get('translator')->trans($message);

				//$this->get('session')->getFlashBag()->('warning', $message);
				$this->get('session')->getFlashBag()->add('warning', $message);

		} /* /storeWarning */

		/**
		 * Store an error
		 * @param string $message 
		 */
		protected function storeError($message) { 

				$this->get('session')->getFlashBag()->add('error', $message);

		} /* /storeWarning */

		/**
		 * Return a new EnvChoice for a form
		 */
		protected function getEnvChoiceType() { return new EnvChoiceType(); }

		/**
		 * Return new ModeSqlChoice for a form
		 */
		protected function getModeSqlChoiceType() { return new ModeSqlChoiceType(); }

		/**
		 * Return new FormatChoice for a form
		 */
		protected function getFormatChoiceType() { return new FormatChoiceType(); }

		/**
		 * From http://benjamin.leveque.me/symfony2-executer-une-commande-depuis-un-controller.html
		 * Return an array containing the message for key messages and containing true or false for exception key
		 * @param $command string the command to be run
		 * @param $arguments array 
		 * @return array infos about execution
		 */
        protected function runCommand($command, $arguments = array())
		{

			// Arguments 
			$args = array_merge(array('command' => $command), $arguments);

			// Input / Output --> Beware : Output is a class of the bundle 
            $input = new ArrayInput($args);
            $output = new ArrayOutput();  //NullOutput();
			
			// Handle Kerner get and app loading
            $kernel = $this->container->get('kernel');
			$app = new Application($kernel);

			// Prepare the return
			$return = array("messages" => "", "exception" => false);

			try {
			   // Run 
			   $app->doRun($input, $output);
			   // The output store messages in an array 
			   $return["messages"] = $output->getMessages();
			} catch(\Exception $e) {
			   // If command fails
			   $this->storeError($e->getMessage());
			   $return["messages"] = array($e->getMessage());
			   $return["exception"] = true;
			}//*/

			// Return
			return $return;
		} // /runCommand

		/**
		 * All returns have the same vars in it so here is a base for the array 
		 * @param $command string 
		 * @param $param array
		 * @param $messages array
		 */
		protected function getAnswerArray($command, $param, $messages) {

				$who = "inconnu";
				$host = $_SERVER['SERVER_NAME'];
				$where = __DIR__;

				return array(
								'who'      => $who,
								'host'     => $host,
								'where'    => $where,
								'command'  => $command,
								'param'    => $param,
								'messages' => $messages
				);

		} /* /getAnswerArray */

		/**
		 * Render when no form are needed (like list)
		 * @param $command string 
		 * @param $param array 
		 * @param $messages array
		 */
		protected function renderMessages($command, $param, $messages) {

				return $this->render('DevBieresCommandBundle:Command:Output.html.twig',
						$this->getAnswerArray($command, $param, $messages)
				  );

		} // /renderMessages

		/**
		 * Render when a form is needed 
		 * @param $command string la command
		 * @param $param string
		 * @param $messages array
		 * @param $form Form
		 * @param $path route
		 */
		protected function renderFormMessages($command, $param, $messages, $form, $path) {
				// Get base array
				$arr = 	$this->getAnswerArray($command, $param, $messages);
				// Adding specific info 
		        $arr['form'] = $form->createView();
	            $arr['route'] = $path;	

				return $this->render('DevBieresCommandBundle:Command:Form.html.twig',
						    $arr
					);

		} /* /renderMessagesAndForm */

		/**
		 * Build an array from the params string
		 * @param $params string 
		 */
		protected function buildParams($params) { 
				// Test
				if(empty($params)) { return array(); }

				$return = array();

				$split = explode(" ", $params);

				foreach($split as $p) {
						// params must be separated by =
						$ps = explode("=", $p);
						// 1 = param / 2 = value. If not value then true
						$return[$ps[0]] = (count($ps) > 1) ? $ps[1] : true;
				} // /foreach

				return $return;

		} // /buildParams

		/**
		 * Handle the generic form
		 */
		public function GenericAction(Request $request) {

				// Data for the form
				$data = array('command' => 'list', 'params' => '');

				// Form creation
				$form = $this->createFormBuilder($data)
						->add('command', 'text', array('label' => 'form.command'))
						->add('params',  'text', array('label' => 'form.params', 'required' => false))
						->getForm();

				// Post
				if($request->isMethod('POST')) {
						// Binding the form and get data
						$form->bind($request);
						// TODO : validation
						$data = $form->getData();
						// Retreive info
						$command = $data["command"];
						$params = $this->buildParams($data["params"]);
				        // Execution
						$r = $this->runCommand($command, $params);
						// Render
                        return $this->renderMessages($data["command"], "", $r["messages"]);
                        
				} // / Post 

				// Rendering the form
				return $this->render(
						'DevBieresCommandBundle:Command:Generic.form.html.twig',
						array(
                             'form' => $form->createView()
				        )
				); // Form

		} /* /GenericAction */

} /* /BaseCommandController */
