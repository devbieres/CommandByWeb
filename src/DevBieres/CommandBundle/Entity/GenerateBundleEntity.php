<?php
namespace DevBieres\CommandBundle\Entity;
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

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entity used in generation of entity
 */
class GenerateBundleEntity {

        public function __construct() {
				$this->fields = new ArrayCollection();
		} /* /__construct */

		/**
		 * @var ArrayCollection fields
		 * */
		protected $fields;
		public function getFields() { return $this->fields; }

		/**
		 * @var string bundle
		 * @Assert\NotBlank()
		 * @Assert\Type(type="string")
		 * */
		private $bundle;
		public function getBundle() { return $this->bundle; }
		public function setBundle($value) { $this->bundle = $value; }

		/**
		 * @var string entity
		 * @Assert\NotBlank()
		 * @Assert\Type(type="string")
		 * */
		private $entity;
		public function getEntity() { return $this->entity; }
		public function setEntity($value) { $this->entity = $value; }


		/**
		 * @var string mode
		 * @Assert\Choice(choices = {"php", "xml", "yml", "annotation"})
		 * */
		private $mode = "annotation";
		public function getMode() { return $this->mode; }
		public function setMode($value) { $this->mode = $value; }

		/**
		 * @var bool repo
		 * @Assert\Type(type="bool")
		 * */
		private $repo = false;
		public function getRepo() { return $this->repo; }
		public function setRepo($value) { $this->repo = $value; }


		public function getParams() {

			// Setting the params
			$params = array(
				"--entity"          => sprintf('%s:%s', $this->getBundle(), $this->getEntity()),
				"--format"          => $this->getMode(),
				"--with-repository" => $this->getRepo(),
				"--no-interaction"  => true
    		);

			// Fields
			$strFields = "";
			foreach($this->getFields() as $field) {
                  $strFields .= sprintf("%s ", $field->getParam());
			} // loop

			// Depending
			if(count(trim($strFields)) > 0) {
					$params["--fields"] = $strFields;
			}

			//
			return $params;
		} /* /getParams */


} /* /GenerateBundleEntity */	

