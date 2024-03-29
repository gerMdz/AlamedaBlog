<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use App\Entity\Post;
use App\Form\Type\DateTimePickerType;
use App\Form\Type\TagsInputType;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Defines the form used to create and manipulate blog posts.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
class PostEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // For the full reference of options defined by each form field type
        // see https://symfony.com/doc/current/reference/forms/types.html

        // By default, form fields include the 'required' attribute, which enables
        // the client-side form validation. This means that you can't test the
        // server-side validation errors from the browser. To temporarily disable
        // this validation, set the 'required' attribute to 'false':
        // $builder->add('title', null, ['required' => false, ...]);

        $builder
            ->add('imageFilename', ElFinderType::class, [
                'label' => 'label.image',
                'instance' => 'form',
                'enable' => true,
                'attr' => [
                    'class' => 'form-control'
                    ]
            ])
            ->add('imageAuthor', TextType::class, [
                    'required' => false,
                    'label' => 'label.image_original_author'
                ]
            )
            ->add('imageLinkOriginal', TextType::class, [
                    'required' => false,
                    'label' => 'label.image_original_link'
                ]
            )
            ->add('title', null, [
                'attr' => ['autofocus' => true],
                'label' => 'label.title',
            ])
            ->add('summary', TextareaType::class, [
                'help' => 'help.post_summary',
                'label' => 'label.summary',
            ])
            ->add('slug', TextType::class, [
                'help' => 'help.post_slug',
                'label' => 'label.slug',
            ])
            ->add('content', CKEditorType::class, [
                'attr' => ['rows' => 20],
                'help' => 'help.post_content',
                'label' => 'label.content',
                'config' => [
                    'toolbar' => 'full',
                    'filebrowserBrowseRoute' => 'elfinder',
                    'filebrowserBrowseRouteParameters' => [
                        'instance' => 'default',
                        'homeFolder' => ''
                    ]
                ],
            ])
            ->add('publishedAt', DateTimePickerType::class, [
                'label' => 'label.published_at',
                'help' => 'help.post_publication',
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('tags', TagsInputType::class, [
                'label' => 'label.tags',
                'required' => false,
            ])
            // No sacar el ';'
            ;
            // Es el fin del build
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
