<?php
namespace Dropbox;

/**
 * A request token is used during the three-step OAuth web flow to identify the authorization
 * session.  Once authorization is complete and you have an access token, you don't need
 * the request token anymore.
 *
 * <h4>Storing Request Tokens (primarily for web apps)</h4>
 * <p>
 * If you are doing the three-step OAuth web flow in a web application, it'll probably
 * span two separate HTTP requests to your app.  In the first request you'll call
 * {@link WebAuth::start()} and get a request token.  You need to store that request
 * token somewhere (browser cookie, server-side session, database, etc.) so that you can
 * pass it to {@link WebAuth::finish()} later.
 * </p>
 *
 * <p>
 * You can convert this object into a single string using {@link RequestToken::serialize() serialize()},
 * and use {@link RequestToken::parse() parse()} to convert that string back into an object.
 * </p>
 */
final class RequestToken extends Token
{
    /**
     * Tacked on to the front of the serialized string to distinguish it from other token types.
     *
     * @var string
     */
    private static $TypeTag = "r|";

    /**
     * @internal
     *
     * @param string $key
     * @param string $value
     */
    function __construct($key, $value)
    {
        parent::__construct($key, $value);
    }

    /**
     * Returns a string representation of this request token.  Can be convenient when
     * storing the access token to a file or database.
     *
     * @return string
     */
    function serialize()
    {
        return $this->serializeWithTag(self::$TypeTag);
    }

    /**
     * Convert a string generated by {@link serialize()} back into a {@link RequestToken}
     * object.
     *
     * @param string $data
     * @return RequestToken
     * @throws DeserializeException
     */
    static function deserialize($data)
    {
        $parts = parent::deserializeWithTag(self::$TypeTag, $data);
        return new RequestToken($parts[0], $parts[1]);
    }

    /**
     * Check that a function argument is of type <code>RequestToken</code>.
     *
     * @internal
     */
    static function checkArg($argName, $argValue)
    {
        if (!($argValue instanceof self)) Checker::throwError($argName, $argValue, __CLASS__);
    }

    /**
     * Check that a function argument is either <code>null</code> or of type
     * <code>RequestToken</code>.
     *
     * @internal
     */
    static function checkArgOrNull($argName, $argValue)
    {
        if ($argValue === null) return;
        if (!($argValue instanceof self)) Checker::throwError($argName, $argValue, __CLASS__);
    }
}
