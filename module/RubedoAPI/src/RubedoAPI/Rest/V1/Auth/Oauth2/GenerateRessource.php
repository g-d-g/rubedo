<?php
/**
 * Rubedo -- ECM solution
 * Copyright (c) 2014, WebTales (http://www.webtales.fr/).
 * All rights reserved.
 * licensing@webtales.fr
 *
 * Open Source License
 * ------------------------------------------------------------------------------------------
 * Rubedo is licensed under the terms of the Open Source GPL 3.0 license.
 *
 * @category   Rubedo
 * @package    Rubedo
 * @copyright  Copyright (c) 2012-2013 WebTales (http://www.webtales.fr)
 * @license    http://www.gnu.org/licenses/gpl.html Open Source GPL 3.0 license
 */

namespace RubedoAPI\Rest\V1\Auth\Oauth2;

use RubedoAPI\Entities\API\Definition\FilterDefinitionEntity;
use RubedoAPI\Entities\API\Definition\VerbDefinitionEntity;

/**
 * Class GenerateRessource
 * auth/oauth2/generate
 *
 * @package RubedoAPI\Rest\V1\Auth\Oauth2
 */
class GenerateRessource extends AbstractRessource
{
    /**
     * { @inheritdoc }
     */
    function __construct()
    {
        parent::__construct();
        $this->definition
            ->setName('Generate token')
            ->setDescription('')
            ->editVerb('post', function (VerbDefinitionEntity &$entity) {
                $entity
                    ->setDescription('')
                    ->addInputFilter(
                        (new FilterDefinitionEntity())
                            ->setDescription('User to log in')
                            ->setKey('PHP_AUTH_USER')
                            ->setRequired()

                    )
                    ->addInputFilter(
                        (new FilterDefinitionEntity())
                            ->setDescription('Password for the user')
                            ->setKey('PHP_AUTH_PW')
                            ->setRequired()
                    );
            });
    }

    /**
     * Post to auth/oauth2/generate
     *
     * @param $params
     * @return array
     */
    function postAction($params)
    {
        $output = array('success' => true);
        $response = $this->getAuthAPIService()->APIAuth($params['PHP_AUTH_USER'], $params['PHP_AUTH_PW']);
        $output['token'] = $this->subTokenFilter($response['token']);
        $output['token']['user'] = $this->subUserFilter($response['user']);
        return $output;
    }
}