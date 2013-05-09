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

use Symfony\Component\Console\Output\Output;

/**
 * Implementation of the console output class.
 * As first implementation : very simple. It just stores the messages in an array
class ArrayOutput extends Output {

		/**
		 * Messages
		 */
		private $messages;
		public function getMessages() { return $this->messages; }


        /**
         * Constructor.
         *
         * @param integer                  $verbosity The verbosity level (self::VERBOSITY_QUIET, self::VERBOSITY_NORMAL, self::VERBOSITY_VERBOSE)
         * @param Boolean                  $decorated Whether to decorate messages or not (null for auto-guessing)
         * @param OutputFormatterInterface $formatter Output formatter instance
         *
         */
        public function __construct($verbosity = self::VERBOSITY_NORMAL, $decorated = null, OutputFormatterInterface $formatter = null)
		{
				parent::__construct($verbosity, $decorated, $formatter);

				$this->messages = array();
				$this->messages[] = "";

	    } // / __construct

		/**
		 * Specialization of the doWrite method : store messages in an array
		 */
		protected function doWrite($message, $newline) {
				//
				$this->messages[count($this->messages) - 1] .= nl2br($message);
				//
				if($newline) { $this->messages[] = ""; }

		} // /doWrite

} // /ArrayOutput

