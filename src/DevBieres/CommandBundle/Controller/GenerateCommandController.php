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
 * Some generate command
 */
class GenerateCommandController extends BaseCommandController {

		/**
		 * Action when bundle generated
		 * For the moment : simple page. The generation of bundle needs reload of kernel so redirect instead of render
		 */
		public function GenerateBundleSuccessAction(Request $request, $bundle) {
				// Infos
				$command = "generate:bundle";

				$r = array(sprintf("Bundle generated : %s", $bundle));

				// Rendering
                return $this->renderMessages($command, "", $r);

		} /* /GeneratedBundleAction */

		/**
		 * Execute the generate:bundle
		 * @param Request $request
		 */
		public function GenerateBundleAction(Request $request) {
				// Infos
				$command = "generate:bundle";
				$path    = "generate_bundle";

				// Data definition
				$data = array(
						'namespace'   => '',
						'dir'         => '../src',
						'bundlename'  => '',
						'format'      => 'yml',
						'structure'   => false
				);

				// Form Building 
				$form = $this->createFormBuilder($data)
						->add('namespace', 'text', array('required' => true))
						->add('dir', 'text', array('required' => true))
						->add('bundlename', 'text', array('required' => true))
						->add('format', 'choice',
								array(
										'choices' => array('yml' => 'yml', 'xml' => 'xml', 'php' => 'php', 'annotation' => 'annotation'),
										'required' => true
								)
						)
						->add('structure', 'checkbox', array('required' => false))
						->getForm();

				// Post
				if($request->isMethod('POST')) {
						// Binding the form and getting the data
						$form->bind($request);
						$data = $form->getData();
						// Setting the params
						$params = array(
								"--namespace"      => $data["namespace"],
								"--dir"            => $data["dir"],
								"--bundle-name"    => $data["bundlename"],
								"--format"         => $data["format"],
								"--structure"      => $data["structure"],
                                "--no-interaction" => true
						);
						// URL must be generated BEFORE bundle generation as routing.yml gone be changes
				        $path_success = $this->generateUrl($path . "_success", array('bundle' => $data["bundlename"] ));
				} else {
						// By defaults : help
				       $params = array('--help' => true);
				} 	

				// Execution
				$r = $this->runCommand($command, $params);

				// Return
				if(($request->isMethod('POST')) && (!$r["exception"])) {
						// redirect
						//$kernel = $this->container->get('kernel');
						//$kernel->shutdown();
						var_dump('POST et pas d exception');
				        return $this->redirect($path_success);//, array('bundle' => $data["bundlename"])));
				} else {
				    // Rendering
					return $this->renderFormMessages($command, $params, $r["messages"], $form, $path);
				} 

		} /* /GenerateBundleAction */

}
