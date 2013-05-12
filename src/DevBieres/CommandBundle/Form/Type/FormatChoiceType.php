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

/**
 * User defined field for chosing env for command
 * http://symfony.com/doc/2.2/cookbook/form/create_custom_field_type.html
 */
class FormatChoiceType extends AbstractType {

		public function setDefaultOptions(OptionsResolverInterface $resolver) {

				$resolver->setDefaults(
								array(
										'label'    => 'form.mode',
										'choices' => array('yml' => 'yml', 'xml' => 'xml', 'php' => 'php', 'annotation' => 'annotation'),
										'required' => true
								)
				);

		} /* /setDefaultOptions */

		public function getParent() { return 'choice'; }

		public function getName() { return 'formatchoice'; }

} /* /EnvChoiceType */



