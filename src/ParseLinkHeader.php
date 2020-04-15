<?php
namespace TiagoHillebrandt;

/**
 * Parse Link Header.
 *
 * @package TiagoHillebrandt
 * @author Tiago Hillebrandt <tiago@tiagohillebrandt.com>
 */
class ParseLinkHeader
{
	/**
	 * The 'Link' header original value.
	 *
	 * @var string|null
	 */
	protected $linkHeader = null;

	/**
	 * ParseLinkHeader constructor.
	 *
	 * @param string $linkHeader The 'Link' header original value.
	 */
	public function __construct($linkHeader)
	{
		$this->linkHeader = $linkHeader;
	}

	/**
	 * Parses the link header and returns the values as an array.
	 *
	 * @return array|false False on error.
	 */
	public function toArray()
	{
		if (!is_string($this->linkHeader))
		{
			return false;
		}

		if (false === strpos($this->linkHeader, ','))
		{
			$links[] = $this->linkHeader;
		} else {
			$links = explode(',', $this->linkHeader);
		}

		if (!is_array($links) || empty($links))
		{
			error_log('The link header value is empty or is not valid');
			return false;
		}

		$values = [];

		foreach (explode(',', $this->linkHeader) as $header)
		{
			$values = array_merge($values, $this->extractData($header));
		}

		return $values;
	}

	/**
	 * Extracts header data.
	 *
	 * @param string $linkHeader The 'Link' header value.
	 *
	 * @return array
	 */
	public function extractData($linkHeader)
	{
		preg_match('/<(.*?(?:(?:\?|\&)page=(\d).*)?)>.*rel="(.*)"/', $linkHeader, $matches, PREG_UNMATCHED_AS_NULL);

		return [
			$matches[3] => [
				'link' => $matches[1],
				'page' => $matches[2],
			],
		];
	}
}
