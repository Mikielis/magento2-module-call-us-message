<?php

namespace Mikielis\StockCallUs\Helper;

/**
 * Class Data
 * @package Mikielis\StockCallUs\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	/**
	 * Enable/Disable path (core_config_data db table)
	 */
	const XML_PATH_ENABLED = 'mikielis_stockcallus/main/enable';

	/**
	 * Phone number (core_config_data db table)
	 */
	const XML_PATH_PHONE_NUMBER = 'mikielis_stockcallus/main/phone_number';

	/**
	 * Text (core_config_data db table)
	 */
	const XML_PATH_TEXT	= 'mikielis_stockcallus/main/text';

	/**
	 * @var \Magento\Framework\ObjectManagerInterface
	 */
	protected $_objectManager;

	/**
	 * @var boolean
	 */
	protected $_isModuleEnabled;

	/**
	 * Data constructor.
	 * @param \Magento\Framework\App\Helper\Context $context
	 * @param \Magento\Framework\ObjectManagerInterface $objectManager
	 */
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\ObjectManagerInterface $objectManager
	) {
		$this->_objectManager = $objectManager;
		parent::__construct($context);
	}

	/**
	 * @return boolean
	 */
	public function isModuleEnabled()
	{
		if (is_null($this->_isModuleEnabled)) {
			$this->_isModuleEnabled = (bool) $this->scopeConfig->getValue(self::XML_PATH_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		}

		return $this->_isModuleEnabled;
    }

	/**
	 * Check whether the price should be hidden
	 * @return bool
	 */
	public function getMessage()
	{
		if ($this->isModuleEnabled() === true) {
			$phone = $this->scopeConfig->getValue(self::XML_PATH_PHONE_NUMBER, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
			$text = $this->scopeConfig->getValue(self::XML_PATH_TEXT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

			if (!empty($phone) && !empty($text) && strpos($text, '[phone]') !== false) {
				return str_replace('[phone]', '<a href="tel:' . $phone . '">' . $phone . "</a>", $text);
			}
		}
		
		return '';
	}
}