<?php
namespace Dropbox;

/**
 * A token that serves as "proof" to Dropbox that you can make API calls against
 * some Dropbox user's account.  This token is embedded in every API request
 * so that the Dropbox server knows the request is authorized.  This token is
 * associated with a specific application, so the Dropbox server knows which
 * application is making requests.
 *
 * <p>
 * Do not share any of your access tokens with anybody, or they will be able to make
 * API requests pretending to be your application.
 * </p>
 *
 * <p>
 * You get an access token from {@link WebAuth::finish()}.
 * </p>
 *
 * <h4>Storing Access Tokens</h4>
 * <p>
 * Once you have an access token, they are valid for many years and so you'll typically
 * store it somewhere long-lived, like a database or a file.
 * </p>
 *
 * <p>
 * You can convert this object into a single string using {@link AccessToken::serialize() serialize()},
 * and use {@link AccessToken::parse() parse()} to convert that string back into an object.
 * </p>
 */
final class AccessToken extends Token
{
    /**
     * Tacked on to the front of the serialized string to distinguish it from other token types.
     *
     * @var string
     */
    private static $TypeTag = "a|";

    /**
     * @param string $key
     * @param string $value
     *
     * @internal
     */
    function __construct($key, $value)
    {
        parent::__construct($key, $value);
    }

    /**
     * Returns a string representation of this access token.  Can be convenient when
     * storing the access token to a file or database.
     *
     * @return string
     */
    function serialize()
    {
        return $this->serializeWithTag(self::$TypeTag);
    }

    /**
     * Convert a string generated by {@link serialize()} back into a {@link AccessToken}
     * object.
     *
     * @param string $data
     * @return AccessToken
     * @throws DeserializeException
     */
    static function deserialize($data)
    {
        $parts = parent::deserializeWithTag(self::$TypeTag, $data);
        return new AccessToken($parts[0], $parts[1]);
    }

    /**
     * Check that a function argument is of type <code>AccessToken</code>.
     *
     * @internal
     */
    static function checkArg($argName, $argValue)
    {
        if (!($argValue instanceof self)) Checker::throwError($argName, $argValue, __CLASS__);
    }

    /**
     * Check that a function argument is either <code>null</code> or of type
     * <code>AccessToken</code>.
     *
     * @internal
     */
    static function checkArgOrNull($argName, $argValue)
    {
        if ($argValue === null) return;
        if (!($argValue instanceof self)) Checker::throwError($argName, $argValue, __CLASS__);
    }
}
