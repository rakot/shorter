<?php
    /**
     * An example of extending the provider class.
     *
     * @author Sergey Vardanyan <rakot.ss@gmail.com>
     * @license http://www.opensource.org/licenses/bsd-license.php
     */

    require_once dirname(dirname(__FILE__)).'/services/FacebookOAuthService.php';

class CustomFacebookService extends FacebookOAuthService {

    protected $scope = 'user_birthday, user_hometown, user_interests, user_location, user_relationships, user_relationship_details, email';


}