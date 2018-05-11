<?php

    namespace Extera\FormBuilderToDbBundle\EventListener;

    use FormBuilderBundle\Event\SubmissionEvent;
    use Pimcore\Model\DataObject\ExtForm;
    use Pimcore\Model\DataObject\Folder;
    use Pimcore\Tool;
    use Symfony\Component\EventDispatcher\EventSubscriberInterface;
    use FormBuilderBundle\FormBuilderEvents;


    class FormListener implements EventSubscriberInterface
    {
        public static function getSubscribedEvents()
        {
            return
            [
                FormBuilderEvents::FORM_SUBMIT_SUCCESS => 'formSubmitSuccess',
            ];
        }



        public function formSubmitSuccess(SubmissionEvent $event)
        {

            dump('Extera\FormBuilderToDbBundle'); die();

            $formKeyName = $event->getForm()->getConfig()->getName();
            $postData = $event->getRequest()->request->get($formKeyName);

            $form = $event->getForm()->getData();
            $formName = $form->getName();
            $fieldsArray = $form->getFields();

            $values_table = [];
            foreach ($fieldsArray as $key => $value) {
                if ($value->getType() != 'submit'){
                    $values_table[] = [$key, $postData[$key]];
                }
            }

            $o_parent = $this->setTreeFolderSkeleton($formName);

            $entry = new ExtForm();
            $entry->setParentId($o_parent)
                ->setKey(uniqid(strtolower($formName).'~'))
                ->setForm_name($formName)
                ->setFields_values($values_table)
                ->setRaw_values(json_encode($postData))
                ->setEmail($postData['email'])
                ->setIp(Tool::getClientIp())
                ->setUrl($event->getRequest()->server->get('SCRIPT_URI'))
            ;

            try{
                $entry->save();
            }catch (\Exception $e){
                $e->getMessage();
            }

        }



        /**
         *
         * @param $formName
         * @return int
         * @throws \Exception
         *
         * Genero la struttura delle cartelle per salvare i form
         *
         * /contact-form
         *      /form-name1
         *              /entry1
         *              /...
         *      /form-name2
         *              /entry1
         *              /...*
         *
         *
         */
        private function setTreeFolderSkeleton($formName)
        {
            //check root
            $folder = Folder::getByPath('/contact-form');
            if (is_null($folder))
            {
                $folder = new Folder();
                $folder->setParentId(1);
                $folder->setKey('contact-form');
                $folder->setLocked(TRUE);
                $folder->save();
            }

            $rootId = $folder->getId();

            //folder specifica del form
            $folder2 = Folder::getByPath('/contact-form/'.$formName);
            if (is_null($folder2))
            {
                $folder2 = new Folder();
                $folder2->setParentId($rootId);
                $folder2->setKey($formName);
                $folder2->setLocked(TRUE);
                $folder2->save();
            }

            return $folder2->getId();
        }

    }
