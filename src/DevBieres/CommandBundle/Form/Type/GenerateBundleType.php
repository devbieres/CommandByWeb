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
class GenerateBundleType extends AbstractType {

		public function buildForm(FormBuilderInterface $builder, array $options) {
				$builder
						->add('bundle', 'bundle', array('required' => true))
						->add('entity', 'text',   array('required' => true, 'label' => 'form.bundle.entity'))
						->add('mode', 'formatchoice', array('label' => 'form.bundle.mode'))
						->add('repo',   'checkbox', array('required' => false, 'label' => 'form.bundle.repo'))
						->add('fields', 'collection', 
						         array(
										 'type' => new GenerateBundleEntityType()
								)
						);
		} /* /buildForm */

		public function setDefaultOptions(OptionsResolverInterface $resolver) {

				$resolver->setDefaults(array(
						'data_class' => 'DevBieres\CommandBundle\Entity\GenerateBundleEntity'
				));
		} /* /setDefaultOptions */

		public function getName() { return 'GenerateBundleType'; }

} /* /GenerateBundleType */

