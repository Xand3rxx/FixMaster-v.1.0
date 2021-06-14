INSERT INTO `rfq_suppliers` (`id`, `rfq_id`, `supplier_id`, `devlivery_fee`, `delivery_time`) VALUES
(1, 1, 19, 1450, '2021-04-07 07:07:36'); 

INSERT INTO `rfqs` (`id`, `uuid`, `unique_id`, `issued_by`, `service_request_id`, `type`, `status`, `accepted`, `total_amount`, `deleted_at`, `created_at`, `updated_at`) VALUES (NULL, '1045f599-769a-41d0-93bb-06f88ee7357u', 'RFQ-C85BEA22', '3', '3', 'Request', 'Pending', 'None', '0', NULL, '2020-12-28 15:58:54', '2021-01-02 14:38:30'); 

INSERT INTO `rfq_supplier_invoices` (`id`, `uuid`, `rfq_id`, `supplier_id`, `delivery_fee`, `delivery_time`, `total_amount`, `accepted`, `created_at`, `updated_at`) VALUES (NULL, 'f069b894-60f4-411c-a5a0-1fa3909e61d5', '2', '21', '1000', '2021/04/16', '0', 'Yes', NULL, NULL); 

INSERT INTO `rfq_batches` (`id`, `rfq_id`, `manufacturer_name`, `model_number`, `component_name`, `quantity`, `size`, `unit_of_measurement`, `image`, `amount`) VALUES (NULL, '2', 'Techscrew', 'RM-3248', '8GB RAM', '2', '0', 'Bytes', '6f526b98-fa6d-4391-b69a-551aa1487b0f.jpg', '0'); 

INSERT INTO `rfq_supplier_invoice_batches` (`id`, `rfq_supplier_invoice_id`, `rfq_batch_id`, `quantity`, `unit_price`, `total_amount`) VALUES (NULL, '1', '2', '2', '700', '1400');

INSERT INTO `service_request_warranties` (`id`, `uuid`, `client_id`, `warranty_id`, `service_request_id`, `start_date`, `expiration_date`, `amount`, `status`, `initiated`, `has_been_attended_to`, `reason`, `date_initiated`, `date_resolved`, `created_at`, `updated_at`) VALUES (NULL, 'cdac7e94-07ee-456d-99a0-88bd9ed04cc1', '5', '1', '3', '2021-04-12 22:35:05', '2021-04-19 16:35:54', '1150', 'unused', 'No', 'No', 'The laptop became faulty after 1 week', NULL, NULL, NULL, NULL);
UPDATE `service_request_warranties` SET `start_date` = '2021-06-01 16:14:02' WHERE `service_request_warranties`.`id` = 3; 
UPDATE `service_request_warranties` SET `expiration_date` = '2021-06-08 16:14:29' WHERE `service_request_warranties`.`id` = 3; 