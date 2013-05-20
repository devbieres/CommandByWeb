<?php
namespace DevBieres\CommandBundle\Form\Type;
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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

/**
 * User defined field for chosing env for command
 * http://symfony.com/doc/2.2/cookbook/form/create_custom_field_type.html
 */
class BundleChoiceType extends AbstractType {

		/**
		 * @param Container
		 */
		private $container;

		public function __construct($container) {
             $this->container = $container;
		} /* /__construct */


		public function setDefaultOptions(OptionsResolverInterface $resolver) {
				// Get the bundle list
				$bundles = array_keys($this->container->get('kernel')->getBundles());
				// 
				$choiceList = new ChoiceList($bundles, $bundles);
				//var_dump($choiceList);

				$resolver->setDefaults(
								array(
										'label'    => 'form.bundles',
										'choice_list'  => $choiceList,
										'required' => true
								)
				);

		} /* /setDefaultOptions */

		public function getParent() { return 'choice'; }

		public function getName() { return 'bundle'; }

} /* /EnvChoiceType */



