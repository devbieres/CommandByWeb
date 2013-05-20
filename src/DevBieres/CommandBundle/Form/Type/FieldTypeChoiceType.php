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
use Doctrine\DBAL\Types\Type;

/**
 * User defined for Field Type
 * http://symfony.com/doc/2.2/cookbook/form/create_custom_field_type.html
 */
class FieldTypeChoiceType extends AbstractType {

		public function setDefaultOptions(OptionsResolverInterface $resolver) {
                // Get the types
                $types = array_keys(Type::getTypesMap());
                // Create a ChoiceListe
				$choiceList = new ChoiceList($types, $types);

				$resolver->setDefaults(
								array(
										'label'    => 'form.fields.type',
										'choice_list'  => $choiceList,
										'required' => true
								)
				);

		} /* /setDefaultOptions */

		public function getParent() { return 'choice'; }

		public function getName() { return 'fieldtypechoice'; }

} /* /EnvChoiceType */



