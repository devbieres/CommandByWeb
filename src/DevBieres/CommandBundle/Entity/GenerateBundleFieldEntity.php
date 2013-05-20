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

/**
 * Entity used in generation of entity
 */
class GenerateBundleFieldEntity {


		/**
		 * @var string name
		 * @Assert\NotBlank()
		 * @Assert\Type(type="string")
		 * */
		private $name = "";
		public function getName() { return $this->name; }
		public function setName($value) { $this->name = $value; }

		/**
		 * @var string type
		 * @Assert\NotBlank()
		 * @Assert\Type(type="string")
		 * */
		private $type;
		public function getType() { return $this->type; }
		public function setType($value) { $this->type = $value; }


		/**
		 * @var integer length
		 * @Assert\Type(type="integer")
		 * @Assert\Range(min = 0, max = 2048)
		 * */
		private $length;
		public function getLength() { return $this->length; }
		public function setLength($value) { $this->length = $value; }

        /**
		 * Return a string format as need for the command
		 * @return string
		 */
		public function getParam() {
				$str = "";
				if(count(trim($this->getName())) > 0) { 
                    $str = sprintf("%s:%s", $this->getName(), $this->getType());
					if($this->getType() == "string") {
							$str = sprintf("%s(%s)", $str, $this->getLength());
					} 
				}
		        return $str;
		} /* /getParam */



} /* /GenerateBundleFieldEntity */	

