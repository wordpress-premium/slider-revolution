<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2024 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderSvgSanitizer
{

	/**
	 * @var DOMDocument
	 */
	protected $svgDocument;
	
	/**
	 * @var DOMXPath
	 */
	protected $xPath;

	/**
	 * @var RevSliderSvgSubject[]
	 */
	protected $subjects = [];
	
	/**
	 * @var array DOMElement[]
	 */
	protected $toRemove = [];

	/**
	 * @var string
	 */
	protected $defaultNSURI;

	/**
	 * @var array
	 */
	protected $allowedTags = [
		// HTML
		'a',
		'font',
		'image',
		'style',

		// SVG
		'svg',
		'altglyph',
		'altglyphdef',
		'altglyphitem',
		'animatecolor',
		'animatemotion',
		'animatetransform',
		'circle',
		'clippath',
		'defs',
		'desc',
		'ellipse',
		'filter',
		'font',
		'g',
		'glyph',
		'glyphref',
		'hkern',
		'image',
		'line',
		'lineargradient',
		'marker',
		'mask',
		'metadata',
		'mpath',
		'path',
		'pattern',
		'polygon',
		'polyline',
		'radialgradient',
		'rect',
		'stop',
		'switch',
		'symbol',
		'text',
		'textpath',
		'title',
		'tref',
		'tspan',
		'use',
		'view',
		'vkern',

		// SVG Filters
		'feBlend',
		'feColorMatrix',
		'feComponentTransfer',
		'feComposite',
		'feConvolveMatrix',
		'feDiffuseLighting',
		'feDisplacementMap',
		'feDistantLight',
		'feFlood',
		'feFuncA',
		'feFuncB',
		'feFuncG',
		'feFuncR',
		'feGaussianBlur',
		'feMerge',
		'feMergeNode',
		'feMorphology',
		'feOffset',
		'fePointLight',
		'feSpecularLighting',
		'feSpotLight',
		'feTile',
		'feTurbulence',

		//text
		'#text'
	];

	/**
	 * @var array
	 */
	protected $allowedAttrs = [
		// HTML
		'about',
		'accept',
		'action',
		'align',
		'alt',
		'autocomplete',
		'background',
		'bgcolor',
		'border',
		'cellpadding',
		'cellspacing',
		'checked',
		'cite',
		'class',
		'clear',
		'color',
		'cols',
		'colspan',
		'coords',
		'crossorigin',
		'datetime',
		'default',
		'dir',
		'disabled',
		'download',
		'enctype',
		'encoding',
		'face',
		'for',
		'headers',
		'height',
		'hidden',
		'high',
		'href',
		'hreflang',
		'id',
		'integrity',
		'ismap',
		'label',
		'lang',
		'list',
		'loop',
		'low',
		'max',
		'maxlength',
		'media',
		'method',
		'min',
		'multiple',
		'name',
		'noshade',
		'novalidate',
		'nowrap',
		'open',
		'optimum',
		'pattern',
		'placeholder',
		'poster',
		'preload',
		'pubdate',
		'radiogroup',
		'readonly',
		'rel',
		'required',
		'rev',
		'reversed',
		'role',
		'rows',
		'rowspan',
		'spellcheck',
		'scope',
		'selected',
		'shape',
		'size',
		'sizes',
		'span',
		'srclang',
		'start',
		'src',
		'srcset',
		'step',
		'style',
		'summary',
		'tabindex',
		'title',
		'type',
		'usemap',
		'valign',
		'value',
		'version',
		'width',
		'xmlns',

		// SVG
		'accent-height',
		'accumulate',
		'additivive',
		'alignment-baseline',
		'ascent',
		'attributename',
		'attributetype',
		'azimuth',
		'basefrequency',
		'baseline-shift',
		'begin',
		'bias',
		'by',
		'class',
		'clip',
		'clip-path',
		'clip-rule',
		'color',
		'color-interpolation',
		'color-interpolation-filters',
		'color-profile',
		'color-rendering',
		'cx',
		'cy',
		'd',
		'dx',
		'dy',
		'diffuseconstant',
		'direction',
		'display',
		'divisor',
		'dur',
		'edgemode',
		'elevation',
		'end',
		'fill',
		'fill-opacity',
		'fill-rule',
		'filter',
		'filterUnits',
		'flood-color',
		'flood-opacity',
		'font-family',
		'font-size',
		'font-size-adjust',
		'font-stretch',
		'font-style',
		'font-variant',
		'font-weight',
		'fx',
		'fy',
		'g1',
		'g2',
		'glyph-name',
		'glyphref',
		'gradientunits',
		'gradienttransform',
		'height',
		'href',
		'id',
		'image-rendering',
		'in',
		'in2',
		'k',
		'k1',
		'k2',
		'k3',
		'k4',
		'kerning',
		'keypoints',
		'keysplines',
		'keytimes',
		'lang',
		'lengthadjust',
		'letter-spacing',
		'kernelmatrix',
		'kernelunitlength',
		'lighting-color',
		'local',
		'marker-end',
		'marker-mid',
		'marker-start',
		'markerheight',
		'markerunits',
		'markerwidth',
		'maskcontentunits',
		'maskunits',
		'max',
		'mask',
		'media',
		'method',
		'mode',
		'min',
		'name',
		'numoctaves',
		'offset',
		'operator',
		'opacity',
		'order',
		'orient',
		'orientation',
		'origin',
		'overflow',
		'paint-order',
		'path',
		'pathlength',
		'patterncontentunits',
		'patterntransform',
		'patternunits',
		'points',
		'preservealpha',
		'preserveaspectratio',
		'r',
		'rx',
		'ry',
		'radius',
		'refx',
		'refy',
		'repeatcount',
		'repeatdur',
		'restart',
		'result',
		'rotate',
		'scale',
		'seed',
		'shape-rendering',
		'specularconstant',
		'specularexponent',
		'spreadmethod',
		'stddeviation',
		'stitchtiles',
		'stop-color',
		'stop-opacity',
		'stroke-dasharray',
		'stroke-dashoffset',
		'stroke-linecap',
		'stroke-linejoin',
		'stroke-miterlimit',
		'stroke-opacity',
		'stroke',
		'stroke-width',
		'style',
		'surfacescale',
		'tabindex',
		'targetx',
		'targety',
		'transform',
		'text-anchor',
		'text-decoration',
		'text-rendering',
		'textlength',
		'type',
		'u1',
		'u2',
		'unicode',
		'values',
		'viewbox',
		'visibility',
		'vector-effect',
		'vert-adv-y',
		'vert-origin-x',
		'vert-origin-y',
		'width',
		'word-spacing',
		'wrap',
		'writing-mode',
		'xchannelselector',
		'ychannelselector',
		'x',
		'x1',
		'x2',
		'xmlns',
		'y',
		'y1',
		'y2',
		'z',
		'zoomandpan',

		// MathML
		'accent',
		'accentunder',
		'align',
		'bevelled',
		'close',
		'columnsalign',
		'columnlines',
		'columnspan',
		'denomalign',
		'depth',
		'dir',
		'display',
		'displaystyle',
		'fence',
		'frame',
		'height',
		'href',
		'id',
		'largeop',
		'length',
		'linethickness',
		'lspace',
		'lquote',
		'mathbackground',
		'mathcolor',
		'mathsize',
		'mathvariant',
		'maxsize',
		'minsize',
		'movablelimits',
		'notation',
		'numalign',
		'open',
		'rowalign',
		'rowlines',
		'rowspacing',
		'rowspan',
		'rspace',
		'rquote',
		'scriptlevel',
		'scriptminsize',
		'scriptsizemultiplier',
		'selection',
		'separator',
		'separators',
		'slope',
		'stretchy',
		'subscriptshift',
		'supscriptshift',
		'symmetric',
		'voffset',
		'width',
		'xmlns',

		// XML
		'xlink:href',
		'xml:id',
		'xlink:title',
		'xml:space',
		'xmlns:xlink',
	];

	/**
	 * @var
	 */
	protected $xmlOriginalEntityLoader;

	/**
	 * @var bool
	 */
	protected $xmlOriginalErrorHandler;

	/**
	 * @var int
	 */
	protected $useThreshold = 1000;

	/**
	 * @var int
	 */
	protected $nestingLimit = 15;

	/**
	 * @var array
	 */
	protected $whitelistDomains;

	/**
	 *
	 */
	function __construct()
	{
		$this->whitelistDomains = $this->getWhitelistDomains();
	}

	/**
	 * Reset DOMDocument and update libXML settings before sanitize
	 */
	protected function beforeSanitize()
	{
		$this->svgDocument = new DOMDocument();
		$this->svgDocument->preserveWhiteSpace = false;
		$this->svgDocument->strictErrorChecking = false;
		$this->svgDocument->formatOutput = true;

		$this->xmlOriginalErrorHandler = libxml_use_internal_errors(true);
		if (LIBXML_VERSION < 20900) {
			$this->xmlOriginalEntityLoader = libxml_disable_entity_loader(true);
		}
	}

	/**
	 * Restore libXML settings after sanitize
	 */
	protected function afterSanitize()
	{
		libxml_clear_errors();
		libxml_use_internal_errors($this->xmlOriginalErrorHandler);
		if (LIBXML_VERSION < 20900) {
			libxml_disable_entity_loader($this->xmlOriginalEntityLoader);
		}
	}

	/**
	 * Sanitize the passed string
	 *
	 * @param string $svgStr
	 * @return string|false
	 */
	public function sanitize($svgStr)
	{
		if (empty($svgStr)) return '';
		
		do {
			$svgStr = preg_replace('/<\?(=|php)(.+?)\?>/i', '', $svgStr);
		} while (preg_match('/<\?(=|php)(.+?)\?>/i', $svgStr) != 0);

		$this->beforeSanitize();

		$loaded = $this->svgDocument->loadXML($svgStr, 0);
		if (!$loaded) {
			$this->afterSanitize();
			return false;
		}

		$this->initXPath();
		$this->processRefs();
		
		$this->doSanitize($this->svgDocument->childNodes, $this->toRemove);
		
		$clean = $this->svgDocument->saveXML($this->svgDocument->documentElement);
		
		$this->afterSanitize();

		return $clean;
	}

	/**
	 * Sanitize tags & attributes
	 *
	 * @param DOMNodeList $elements
	 * @param array $toRemove
	 */
	protected function doSanitize(DOMNodeList $elements, array $toRemove)
	{
		for ($i = $elements->length - 1; $i >= 0; $i--) {
			/** @var DOMElement $el */
			$el = $elements->item($i);

			if (in_array($el, $toRemove) && 'use' === $el->nodeName) {
				$el->parentNode->removeChild($el);
				continue;
			}

			if ($el instanceof DOMElement) {
				// check against whitelist
				if (!in_array(strtolower($el->tagName), $this->allowedTags)) {
					$el->parentNode->removeChild($el);
					continue;
				}

				$this->cleanHrefs($el);
				$this->cleanXlinkHrefs($el);
				$this->checkAttributes($el);

				if (strtolower($el->tagName) === 'use') {
					
					$href = $this->getHrefAttribute($el);
					if (($href && strpos($href, '#') !== 0)) {
						$el->parentNode->removeChild($el);
						continue;
					}

					if ($this->useThreshold > 0) {
						$useId = $this->extractHrefId($this->getHrefAttribute($el));
						if (!is_null($useId)) {
							foreach ($this->findByElementId($useId) as $subject) {
								if ($subject->countUse() >= $this->useThreshold) {
									$el->parentNode->removeChild($el);
									continue;
								}
							}
						}
					}
				}

				// Strip out font elements that will break out of foreign content.
				if (strtolower($el->tagName) === 'font') {
					$breaksOutOfForeignContent = false;
					for ($x = $el->attributes->length - 1; $x >= 0; $x--) {
						$attrName = $el->attributes->item($x)->nodeName;
						if (in_array(strtolower($attrName), ['face', 'color', 'size'])) {
							$breaksOutOfForeignContent = true;
						}
					}

					if ($breaksOutOfForeignContent) {
						$el->parentNode->removeChild($el);
						continue;
					}
				}
			}

			$this->cleanNodes($el);

			if ($el->hasChildNodes()) {
				$this->doSanitize($el->childNodes, $toRemove);
			}
		}
	}

	/**
	 * Check attributes against whitelist
	 *
	 * @param DOMElement $element
	 */
	protected function checkAttributes($element)
	{
		for ($x = $element->attributes->length - 1; $x >= 0; $x--) {
			$attr = $element->attributes->item($x)->nodeName;

			if (
				!in_array(strtolower($attr), $this->allowedAttrs) 
				&& !(strpos(strtolower($attr), 'aria-') === 0) 
				&& !(strpos(strtolower($attr), 'data-') === 0)
			) {
				$element->removeAttribute($attr);
			}

			if (false !== strpos($attr, 'href')) {
				$href = $element->getAttribute($attr);
				if (false === $this->isHrefSafe($href)) {
					$element->removeAttribute($attr);
				}
			}

			// Remove attribute if it has a remote reference
			if (isset($element->attributes->item($x)->value) && $this->hasRemoteRef($element->attributes->item($x)->value)) {
				$element->removeAttribute($attr);
			}
		}
	}

	/**
	 * Clean the xlink:hrefs of script and data embeds
	 *
	 * @param DOMElement $element
	 */
	protected function cleanXlinkHrefs($element)
	{
		$xlinks = $element->getAttributeNS('http://www.w3.org/1999/xlink', 'href');
		if (false === $this->isHrefSafe($xlinks)) {
			$element->removeAttributeNS('http://www.w3.org/1999/xlink', 'href');
		}
	}

	/**
	 * Clean the hrefs of script and data embeds
	 *
	 * @param DOMElement $element
	 */
	protected function cleanHrefs($element)
	{
		$href = $element->getAttribute('href');
		if (false === $this->isHrefSafe($href)) {
			$element->removeAttribute('href');
		}
	}

	/**
	 * Does this attribute value have a remote reference?
	 *
	 * @param $value
	 * @return bool
	 */
	protected function hasRemoteRef($value)
	{
		$value = trim(preg_replace('/[^ -~]/xu', '', $value));

		$wrapped_in_url = preg_match('~^url\(\s*[\'"]\s*(.*)\s*[\'"]\s*\)$~xi', $value, $match);
		if (!$wrapped_in_url) {
			return false;
		}

		$value = trim($match[1], '\'"');

		return preg_match('~^((https?|ftp|file):)?//~xi', $value);
	}

	/**
	 * Remove nodes that are invalid
	 *
	 * @param DOMNode $currentElement
	 */
	protected function cleanNodes($currentElement)
	{
		// Replace CDATA node with encoded text node
		if ($currentElement instanceof DOMCdataSection) {
			$textNode = $currentElement->ownerDocument->createTextNode($currentElement->nodeValue);
			$currentElement->parentNode->replaceChild($textNode, $currentElement);
			// If the element doesn't have a tagname, remove it and continue with next iteration
		} elseif (!$currentElement instanceof DOMElement && !$currentElement instanceof DOMText) {
			$currentElement->parentNode->removeChild($currentElement);
			return;
		}

		if ($currentElement->childNodes && $currentElement->childNodes->length > 0) {
			for ($j = $currentElement->childNodes->length - 1; $j >= 0; $j--) {
				/** @var DOMElement $childElement */
				$childElement = $currentElement->childNodes->item($j);
				$this->cleanNodes($childElement);
			}
		}
	}

	/**
	 * return domains used by wp installation
	 * both backend and frontend
	 *
	 * @return array
	 */
	protected function getWhitelistDomains()
	{
		$domains = [];
		$sites = [(object)['id' => get_current_blog_id()]];
		if (is_multisite()) {
			$sites = get_sites();
		}

		foreach ($sites as $site) {
			$domains[] = parse_url(get_site_url($site->id), PHP_URL_HOST);
			$domains[] = parse_url(get_admin_url($site->id), PHP_URL_HOST);
		}

		return array_unique($domains);
	}

	/**
	 * validate href
	 *
	 * @param $value
	 * @return bool
	 */
	protected function isHrefSafe($value)
	{
		// Don't allow non-strings
		if (!is_string($value)) {
			return false;
		}

		// Allow empty values
		if (empty($value)) {
			return true;
		}

		// Allow fragment identifiers.
		if ('#' === $value[0]) {
			return true;
		}

		// Allow relative URIs.
		if ('/' === $value[0] && '/' !== $value[1]) {
			return true;
		}

		// Allow known data URIs.
		if (in_array(substr($value, 0, 14), array(
			'data:image/png', // PNG
			'data:image/gif', // GIF
			'data:image/jpg', // JPG
			'data:image/jpe', // JPEG
			'data:image/pjp', // PJPEG
		))) {
			return true;
		}

		// Allow known short data URIs.
		if (in_array(substr($value, 0, 12), array(
			'data:img/png', // PNG
			'data:img/gif', // GIF
			'data:img/jpg', // JPG
			'data:img/jpe', // JPEG
			'data:img/pjp', // PJPEG
		))) {
			return true;
		}

		// Allow urls from white list
		if (!empty($this->whitelistDomains)) {
			$pattern = "/^(http|https|)\:\/\/(?:www\.)?(?:" . str_replace('.', '\.', implode('|', $this->whitelistDomains)) . ")\/.*\.(jpg|png)$/i";
			if (preg_match($pattern, $value)) return true;
		}

		return false;
	}

	/**
	 * check that document contain only one SVG root element
	 * init XPath object for current document
	 * 
	 * @return void
	 * @throws LogicException
	 */
	protected function initXPath()
	{
		$this->xPath = new DOMXPath($this->svgDocument);

		$root = null;
		$elements = $this->xPath->document->getElementsByTagName('svg');
		foreach ($elements as $element) {
			if ($element->parentNode !== $this->xPath->document) continue;
			if (!is_null($root)) {
				throw new LogicException('Two or more SVG root elements found');
			}
			$root = $element;
		}
		
		$this->defaultNSURI = (string)$root->namespaceURI;
		if ($this->defaultNSURI !== '') {
			$this->xPath->registerNamespace('svg', $this->defaultNSURI);
		}
	}

	/**
	 * @param string $nodeName
	 * @return string
	 */
	public function getNodeName($nodeName)
	{
		if (empty($this->defaultNSURI)) {
			return $nodeName;
		}
		return 'svg:' . $nodeName;
	}

	/**
	 * @param string $elementId
	 * @return RevSliderSvgSubject[]
	 */
	public function findByElementId($elementId)
	{
		return array_filter(
			$this->subjects,
			function (RevSliderSvgSubject $subject) use ($elementId) {
				return $elementId === $subject->getElementId();
			}
		);
	}

	/**
	 * Collects elements having `id` attribute
	 * Processes references from and to elements having `id` attribute
	 */
	protected function processRefs()
	{
		/** @var DOMNodeList|DOMElement[] $elements */
		$elements = $this->xPath->query('//*[@id]');
		foreach ($elements as $element) {
			$this->subjects[$element->getAttribute('id')] = new RevSliderSvgSubject($element, $this->nestingLimit);
		}
		
		$useNodeName = $this->getNodeName('use');
		foreach ($this->subjects as $subject) {
			$useElements = $this->xPath->query(
				$useNodeName . '[@href or @xlink:href]',
				$subject->getElement()
			);

			/** @var DOMElement $useElement */
			foreach ($useElements as $useElement) {
				$useId = $this->extractHrefId($this->getHrefAttribute($useElement));
				if ($useId === null || !isset($this->subjects[$useId])) {
					continue;
				}
				$subject->addUse($this->subjects[$useId]);
				$this->subjects[$useId]->addUsedIn($subject);
			}
		}

		foreach ($this->subjects as $subject) {
			if (in_array($subject->getElement(), $this->toRemove)) {
				continue;
			}

			$useId = $this->extractHrefId($this->getHrefAttribute($subject->getElement()));

			if ($useId === $subject->getElementId()) {
				$this->addToRemove($subject);
			}

			$result = $subject->hasInfiniteLoop();
			if ($result instanceof DOMElement) {
				$this->toRemove[] = $result;
				$this->addToRemove($subject);
			} elseif ($result) {
				$this->addToRemove($subject);
			}
		}
	}


	/**
	 * add element ( + children ) to be removed to array
	 *
	 * @param RevSliderSvgSubject $subject
	 */
	protected function addToRemove($subject) {
		$this->toRemove = array_merge(
			$this->toRemove,
			$subject->getAffectedElements()
		);
	}

	/**
	 * @param DOMElement $element
	 * @return string|null
	 */
	protected function getHrefAttribute(DOMElement $element)
	{
		if ($element->hasAttribute('href')) {
			return $element->getAttribute('href');
		}
		if ($element->hasAttributeNS('http://www.w3.org/1999/xlink', 'href')) {
			return $element->getAttributeNS('http://www.w3.org/1999/xlink', 'href');
		}
		
		return null;
	}

	/**
	 * @param string $href
	 * @return string|null
	 */
	protected function extractHrefId($href)
	{
		if (!is_string($href) || strpos($href, '#') !== 0) return null;
		return substr($href, 1);
	}

	/**
	 * @param DOMElement $what
	 * @param DOMElement $where
	 * @return bool
	 */
	protected function isElementIn($what, $where)
	{
		if ($what === $where) return true;

		foreach ($where->childNodes as $childNode) {
			if (!$childNode instanceof DOMElement) continue;
			if ($this->isElementIn($what, $childNode)) return true;
		}

		return false;
	}
}
