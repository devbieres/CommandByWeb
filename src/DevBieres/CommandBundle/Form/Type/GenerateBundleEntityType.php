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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for generate an entity
 */
class GenerateBundleEntityType extends AbstractType {

		public function buildForm(FormBuilderInterface $builder, array $options) {
				$builder
						->add('name', 'text', array('required' => false, 'label' => 'form.fields.name'))
						->add('type', 'fieldtypechoice', array('required' => true))
						->add('length',   'text', array('required' => false, 'label' => 'form.fields.length'));
		} /* /buildForm */

		public function setDefaultOptions(OptionsResolverInterface $resolver) {

				$resolver->setDefaults(array(
						'data_class' => 'DevBieres\CommandBundle\Entity\GenerateBundleFieldEntity'
				));
		} /* /setDefaultOptions */

		public function getName() { return 'GenerateBundleFieldType'; }

} /* /GenerateBundleType */

