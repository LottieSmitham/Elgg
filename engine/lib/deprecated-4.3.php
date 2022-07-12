<?php
/**
 * Bundle all functions which have been deprecated in Elgg 4.3
 */

/**
 * Returns an array of access IDs a user is permitted to see.
 *
 * Can be overridden with the 'access:collections:read', 'user' plugin hook.
 * @warning A callback for that plugin hook needs to either not retrieve data
 * from the database that would use the access system (triggering the plugin again)
 * or ignore the second call. Otherwise, an infinite loop will be created.
 *
 * This returns a list of all the collection ids a user owns or belongs
 * to plus public and logged in access levels. If the user is an admin, it includes
 * the private access level.
 *
 * @see elgg_get_write_access_array() for the access levels that a user can write to.
 *
 * @param int $user_guid User ID; defaults to currently logged in user
 *
 * @return array An array of access collections ids
 * @deprecated 4.3 use elgg_get_access_array()
 */
function get_access_array(int $user_guid = 0): array {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_get_access_array()', '4.3');
	
	return _elgg_services()->accessCollections->getAccessArray($user_guid);
}

/**
 * Gets the default access permission.
 *
 * This returns the default access level for the site or optionally of the user.
 * If want you to change the default access based on group of other information,
 * use the 'default', 'access' plugin hook.
 *
 * @param ElggUser $user         The user for whom we're getting default access. Defaults to logged in user.
 * @param array    $input_params Parameters passed into an input/access view
 *
 * @return int default access id (see ACCESS defines in constants.php)
 * @deprecated 4.3 use elgg_get_default_access()
 */
function get_default_access(ElggUser $user = null, array $input_params = []): int {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_get_default_access()', '4.3');
	
	return elgg_get_default_access($user, $input_params);
}

/**
 * Can a user access an entity.
 *
 * @warning If a logged in user doesn't have access to an entity, the
 * core engine will not load that entity.
 *
 * @tip This is mostly useful for checking if a user other than the logged in
 * user has access to an entity that is currently loaded.
 *
 * @param \ElggEntity $entity The entity to check access for.
 * @param \ElggUser   $user   Optionally user to check access for. Defaults to logged in user (which is a useless default).
 *
 * @return bool
 * @deprecated 4.3 use \ElggEnity->hasAccess() or elgg_has_access_to_entity()
 */
function has_access_to_entity(\ElggEntity $entity, \ElggUser $user = null): bool {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use \ElggEnity->hasAccess() or elgg_has_access_to_entity()', '4.3');
	
	return _elgg_services()->accessCollections->hasAccessToEntity($entity, $user ? $user->guid : 0);
}

/**
 * Returns an array of access permissions that the user is allowed to save content with.
 * Permissions returned are of the form (id => 'name').
 *
 * Example return value in English:
 * array(
 *     0 => 'Private',
 *    -2 => 'Friends',
 *     1 => 'Logged in users',
 *     2 => 'Public',
 *    34 => 'My favorite friends',
 * );
 *
 * Plugin hook of 'access:collections:write', 'user'
 *
 * @warning this only returns access collections that the user owns plus the
 * standard access levels. It does not return access collections that the user
 * belongs to such as the access collection for a group.
 *
 * @param int   $user_guid    The user's GUID.
 * @param int   $ignored      Ignored parameter
 * @param bool  $flush        If this is set to true, this will ignore a cached access array
 * @param array $input_params Some parameters passed into an input/access view
 *
 * @return array List of access permissions
 * @deprecated 4.3 use elgg_get_write_access_array()
 */
function get_write_access_array(int $user_guid = 0, $ignored = 0, bool $flush = false, array $input_params = []): array {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_get_write_access_array()', '4.3');
	
	return _elgg_services()->accessCollections->getWriteAccessArray($user_guid, $flush, $input_params);
}

/**
 * Can the user change this access collection?
 *
 * Use the plugin hook of 'access:collections:write', 'user' to change this.
 * @see elgg_get_write_access_array() for details on the hook.
 *
 * Respects access control disabling for admin users and {@link elgg_call()}
 *
 * @see elgg_get_write_access_array()
 *
 * @param int   $collection_id The collection id
 * @param mixed $user_guid     The user GUID to check for. Defaults to logged in user.
 *
 * @return bool
 * @deprecated 4.3 use \ElggAccessCollection->canEdit()
 */
function can_edit_access_collection(int $collection_id, int $user_guid = null): bool {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use \ElggAccessCollection->canEdit()', '4.3');
	
	return _elgg_services()->accessCollections->canEdit($collection_id, $user_guid);
}

/**
 * Creates a new access collection.
 *
 * Access colletions allow plugins and users to create granular access
 * for entities.
 *
 * Triggers plugin hook 'access:collections:addcollection', 'collection'
 *
 * @note Internal: Access collections are stored in the access_collections table.
 * Memberships to collections are in access_collections_membership.
 *
 * @param string $name       The name of the collection.
 * @param int    $owner_guid The GUID of the owner (default: currently logged in user).
 * @param string $subtype    The subtype indicates the usage of the acl
 *
 * @return int|false The collection ID if successful and false on failure.
 * @deprecated 4.3 use elgg_create_access_collection()
 */
function create_access_collection(string $name, int $owner_guid = 0, $subtype = null) {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_create_access_collection()', '4.3');
	
	return _elgg_services()->accessCollections->create($name, $owner_guid, (string) $subtype) ?? false;
}

/**
 * Deletes a specified access collection and its membership.
 *
 * @param int $collection_id The collection ID
 *
 * @return bool
 * @see elgg_create_access_collection()
 * @deprecated 4.3 use \ElggAccessCollection->delete()
 */
function delete_access_collection(int $collection_id): bool {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use \ElggAccessCollection->delete()', '4.3');
	
	return _elgg_services()->accessCollections->delete($collection_id);
}

/**
 * Get a specified access collection
 *
 * @note This doesn't return the members of an access collection,
 * just the database row of the actual collection.
 *
 * @see get_members_of_access_collection()
 *
 * @param int $collection_id The collection ID
 *
 * @return ElggAccessCollection|false
 * @deprecated 4.3 use elgg_get_access_collection()
 */
function get_access_collection(int $collection_id) {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_get_access_collection()', '4.3');
	
	return _elgg_services()->accessCollections->get($collection_id) ?? false;
}

/**
 * Adds a user to an access collection.
 *
 * Triggers the 'access:collections:add_user', 'collection' plugin hook.
 *
 * @param int $user_guid     The GUID of the user to add
 * @param int $collection_id The ID of the collection to add them to
 *
 * @return bool
 * @deprecated 4.3 use \ElggAccessCollection->addMember()
 */
function add_user_to_access_collection(int $user_guid, int $collection_id): bool {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use \ElggAccessCollection->addMember()', '4.3');
	
	return _elgg_services()->accessCollections->addUser($user_guid, $collection_id);
}

/**
 * Removes a user from an access collection.
 *
 * Triggers the 'access:collections:remove_user', 'collection' plugin hook.
 *
 * @param int $user_guid     The user GUID
 * @param int $collection_id The access collection ID
 *
 * @return bool
 * @deprecated 4.3 use \ElggAccessCollection->removeMember()
 */
function remove_user_from_access_collection(int $user_guid, int $collection_id): bool {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use \ElggAccessCollection->removeMember()', '4.3');
	
	return _elgg_services()->accessCollections->removeUser($user_guid, $collection_id);
}

/**
 * Get all of members of an access collection
 *
 * @param int   $collection_id The collection's ID
 * @param bool  $guids_only    If set to true, will only return the members' GUIDs (default: false)
 * @param array $options       ege* options
 *
 * @return \ElggData[]|int|int[]|mixed guids or entities if successful, false if not
 * @deprecated 4.3 use \ElggAccessCollection->getMembers()
 */
function get_members_of_access_collection(int $collection_id, bool $guids_only = false, array $options = []) {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use \ElggAccessCollection->getMembers()', '4.3');
	
	if (!isset($options['limit'])) {
		$options['limit'] = false;
	}
	
	if (!$guids_only) {
		return _elgg_services()->accessCollections->getMembers($collection_id, $options);
	}
	
	$options['callback'] = function($row) {
		return (int) $row->guid;
	};
	
	return _elgg_services()->accessCollections->getMembers($collection_id, $options);
}

/**
 * Return the name of an ACCESS_* constant or an access collection,
 * but only if the logged in user has write access to it.
 * Write access requirement prevents us from exposing names of access collections
 * that current user has been added to by other members and may contain
 * sensitive classification of the current user (e.g. close friends vs acquaintances).
 *
 * Returns a string in the language of the user for global access levels, e.g.'Public, 'Friends', 'Logged in', 'Public';
 * or a name of the owned access collection, e.g. 'My work colleagues';
 * or a name of the group or other access collection, e.g. 'Group: Elgg technical support';
 * or 'Limited' if the user access is restricted to read-only, e.g. a friends collection the user was added to
 *
 * @param int $entity_access_id The entity's access id
 *
 * @return string
 * @since 1.7.0
 * @deprecated 4.3 use elgg_get_readable_access_level()
 */
function get_readable_access_level(int $entity_access_id): string {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_get_readable_access_level()', '4.3');
	
	return _elgg_services()->accessCollections->getReadableAccessLevel($entity_access_id);
}

/**
 * Return an array reporting the number of various entities in the system.
 *
 * @param int $owner_guid Optional owner of the statistics
 *
 * @return array
 * @deprecated 4.3 use elgg_get_entity_statistics()
 */
function get_entity_statistics(int $owner_guid = 0): array {
	return elgg_get_entity_statistics($owner_guid);
}

/**
 * Register a PAM handler.
 *
 * A PAM handler should return true if the authentication attempt passed. For a
 * failure, return false or throw an exception. Returning nothing indicates that
 * the handler wants to be skipped.
 *
 * Note, $handler must be string callback (not an array/Closure).
 *
 * @param string $handler    Callable global handler function in the format ()
 * 		                     pam_handler($credentials = null);
 * @param string $importance The importance - "sufficient" (default) or "required"
 * @param string $policy     The policy type, default is "user"
 *
 * @return bool
 * @deprecated 4.3 use elgg_register_pam_handler()
 */
function register_pam_handler($handler, $importance = 'sufficient', $policy = 'user') {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_register_pam_handler()', '4.3');
	
	return elgg_register_pam_handler($handler, $importance, $policy);
}

/**
 * Unregisters a PAM handler.
 *
 * @param string $handler The PAM handler function name
 * @param string $policy  The policy type, default is "user"
 *
 * @return void
 * @since 1.7.0
 * @deprecated 4.3 use elgg_unregister_pam_handler()
 */
function unregister_pam_handler($handler, $policy = 'user') {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_unregister_pam_handler()', '4.3');
	
	elgg_unregister_pam_handler($handler, $policy);
}

/**
 * Perform user authentication with a given username and password.
 *
 * @warning This returns an error message on failure. Use the identical operator to check
 * for access: if (true === elgg_authenticate()) { ... }.
 *
 * @see login()
 *
 * @param string $username The username
 * @param string $password The password
 *
 * @return true|string True or an error message on failure
 * @internal
 * @deprecated 4.3 use elgg_pam_authenticate()
 */
function elgg_authenticate($username, $password) {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_pam_authenticate()', '4.3');
	
	$pam = new \ElggPAM('user');
	$credentials = ['username' => $username, 'password' => $password];
	$result = $pam->authenticate($credentials);
	if (!$result) {
		return $pam->getFailureMessage();
	}
	
	return true;
}

/**
 * Generates a unique invite code for a user
 *
 * @param string $username The username of the user sending the invitation
 *
 * @return string Invite code
 * @see elgg_validate_invite_code()
 * @deprecated 4.3 use elgg_generate_invite_code()
 */
function generate_invite_code($username) {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_generate_invite_code()', '4.3');
	
	return elgg_generate_invite_code((string) $username);
}

/**
 * Get external resource descriptors
 *
 * @param string $type     Type of file: js or css
 * @param string $location Page location
 *
 * @return array
 * @since 1.8.0
 * @deprecated 4.3 use elgg_get_loaded_external_resources()
 */
function elgg_get_loaded_external_files(string $type, string $location): array {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_get_loaded_external_resources()', '4.3');
	
	return _elgg_services()->externalFiles->getLoadedFiles($type, $location);
}

/**
 * Get the size of the specified directory.
 *
 * @param string $dir        The full path of the directory
 * @param int    $total_size Add to current dir size
 *
 * @return int The size of the directory in bytes
 *
 * @deprecated 4.3
 */
function get_dir_size($dir, $total_size = 0, $show_deprecation_notice = true) {
	if ($show_deprecation_notice) {
		elgg_deprecated_notice(__METHOD__ . ' has been deprecated', '4.3');
	}
	if (!is_dir($dir)) {
		return $total_size;
	}
	
	$handle = opendir($dir);
	while (($file = readdir($handle)) !== false) {
		if (in_array($file, ['.', '..'])) {
			continue;
		}
		if (is_dir($dir . $file)) {
			$total_size = get_dir_size($dir . $file . "/", $total_size, false);
		} else {
			$total_size += filesize($dir . $file);
		}
	}
	closedir($handle);

	return($total_size);
}

/**
 * Filter tags from a given string based on registered hooks.
 *
 * @param mixed $var Anything that does not include an object (strings, ints, arrays)
 *					 This includes multi-dimensional arrays.
 *
 * @return mixed The filtered result - everything will be strings
 *
 * @deprecated 4.3 use elgg_sanitize_input()
 */
function filter_tags($var) {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_sanitize_input().', '4.3');
	
	return elgg_sanitize_input($var);
}

/**
 * Takes a string and turns any URLs into formatted links
 *
 * @param string $text The input string
 *
 * @return string The output string with formatted links
 *
 * @deprecated 4.3 use elgg_parse_urls()
 */
function parse_urls($text) {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_parse_urls().', '4.3');
	
	return _elgg_services()->html_formatter->parseUrls($text);
}

/**
 * Returns the current page's complete URL.
 *
 * It uses the configured site URL for the hostname rather than depending on
 * what the server uses to populate $_SERVER.
 *
 * @return string The current page URL.
 *
 * @deprecated 4.3 use elgg_get_current_url()
 */
function current_page_url() {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_get_current_url().', '4.3');
	
	return _elgg_services()->request->getCurrentURL();
}

/**
 * Validates an email address.
 *
 * @param string $address Email address.
 *
 * @return bool
 *
 * @deprecated 4.3 use elgg_is_valid_email()
 */
function is_email_address($address) {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_is_valid_email().', '4.3');
	
	return _elgg_services()->accounts->isValidEmail($address);
}

/**
 * Takes in a comma-separated string and returns an array of tags
 * which have been trimmed
 *
 * @param string $string Comma-separated tag string
 *
 * @return mixed An array of strings or the original data if input was not a string
 *
 * @deprecated 4.3 use elgg_string_to_array()
 */
function string_to_tag_array($string) {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_string_to_array().', '4.3');
	
	if (!is_string($string)) {
		return $string;
	}
	
	return elgg_string_to_array($string);
}

/**
 * Add a translation.
 *
 * Translations are arrays in the Zend Translation array format, eg:
 *
 *	$english = array('message1' => 'message1', 'message2' => 'message2');
 *  $german = array('message1' => 'Nachricht1','message2' => 'Nachricht2');
 *
 * @param string $country_code   Standard country code (eg 'en', 'nl', 'es')
 * @param array  $language_array Formatted array of strings
 *
 * @return bool Depending on success
 *
 * @deprecated 4.3 use elgg()->translator->addTranslation()
 */
function add_translation($country_code, $language_array) {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg()->translator->addTranslation().', '4.3');
	
	return _elgg_services()->translator->addTranslation($country_code, $language_array);
}

/**
 * Get the current system/user language or "en".
 *
 * @return string The language code for the site/user or "en" if not set
 *
 * @deprecated 4.3 use elgg_get_current_language()
 */
function get_current_language() {
	elgg_deprecated_notice(__METHOD__ . ' has been deprecated. Use elgg_get_current_language().', '4.3');
	
	return _elgg_services()->translator->getCurrentLanguage();
}
