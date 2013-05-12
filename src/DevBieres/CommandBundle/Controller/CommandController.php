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
 * Contains some generic command like clear:cache, list, ....
 */
class CommandController extends BaseCommandController {

		/**
		 * Handle the cache:clear command
		 * @param Request $request
		 */
		public function ClearCacheAction(Request $request) {

				// Infos
				$command = "cache:clear";
				$path    = "clear_cache";

				// Data definition
				$data = array('nowarmup' => false, 'nooptionnalwarmers' => false, 'env' => 'dev');

				// Form building
				$form = $this->createFormBuilder($data)
						->add('env', $this->getEnvChoiceType())
						->add('nowarmup', 'checkbox', array('label' => 'form.nowarmup', 'required' => false))
						->add('nooptionnalwarmers', 'checkbox', array('label' => 'form.nooptionnalwarmers', 'required' => false))
						->getForm();

				// POST
				if($request->isMethod('POST')) { 
						// Binding and getting data
						$form->bind($request);
						$data = $form->getData();
						// Generate params
						$params = array(
								"--env"                   => $data["env"],
								"--no-warmup"             => $data["nowarmup"],
								"--no-optional-warmers"   => $data["nooptionnalwarmers"]
						);
				} else {
						// By defaults : help
				        $params = array('--help' => true);
				} 	

				// Exec
				$r = $this->runCommand($command, $params);

				// Rendering
				return $this->renderFormMessages($command, $params, $r["messages"], $form, $path);

		} // /ClearCacheAction

		/**
		 * Execute the assets:install
		 */
		public function AssetsInstallAction(Request $request) {
				// Infos
				$command = "assets:install";
				$path = "assets_install"; 

				// Data definition 
				$data = array('symlink' => true, 'relative' => false, 'dir' => '../web');

				// Form building
				$form = $this->createFormBuilder($data)
						->add('symlink', 'checkbox', array('label' => 'form.symlink', 'required' => false))
						->add('relative', 'checkbox', array('label' => 'form.relative', 'required' => false))
						->add('dir',  'text', array('label' => 'form.target'))
						->getForm();

                // POST 
				if($request->isMethod('POST')) { 
						// Binding the form and getting the data
						$form->bind($request);
						$data = $form->getData();
						// Setting the params
						$params = array(
								'--symlink' => $data["symlink"],
								'--relative' => $data["relative"],
								'target' => $data["dir"]
						);
				} else {
						// By defaults : help
						$params = array('--help' => true);
				}

				
				// Execution
				$r = $this->runCommand($command, $params);

				// Rendering
				return $this->renderFormMessages($command, $params, $r["messages"], $form, $path);

		} // /AssetsInstallAction


		/**
		 * Execute the list command : use as default action 
		 */
		public function ListAction() {
				// Infos
				$command = "list";

				// Execution
				$r = $this->runCommand($command);

				// Rendering
                return $this->renderMessages($command, "", $r["messages"]);
		} // /ListAction 

		/**
		 * Execute router:debug 
		 */
		public function RouterDebugAction() {
				// Infos
				$command = "router:debug";

				// Execution
				$r = $this->runCommand($command);

				// Rendering
                return $this->renderMessages($command, "", $r["messages"]);
		} // /ListAction 

}
