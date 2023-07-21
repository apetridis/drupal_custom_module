<?php

// Define namespace, always change the name of custom_template with the module's name
namespace Drupal\custom_template\Plugin\rest\resource;

// Usefull libraries
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Request;
use Drupal\rest\session\token;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Provides a Demo Resource
 *
 * @RestResource(
 *   id = "post_example",
 *   label = @Translation("Post Example"),
 *   uri_paths = {
 *     "create" = "/post/something",
 *   }
 * )
 */
class PostExample extends ResourceBase
{
//   Always change the class name and the details of the commends above
  protected $currentRequest;
  /**
   * A current user instance which is logged in the session.
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $loggedUser;
  /**
   * Constructs a Drupal\rest\Plugin\ResourceBase object.
   *
   * @param array $config
   *   A configuration array which contains the information about the plugin instance.
   * @param string $module_id
   *   The module_id for the plugin instance.
   * @param mixed $module_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   A currently logged user instance.
   */
  public function __construct(
    array $config,
    $module_id,
    $module_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    AccountProxyInterface $current_user,
    Request $current_request) {
    parent::__construct($config, $module_id, $module_definition, $serializer_formats, $logger);

    $this->loggedUser = $current_user;    
    $this->currentRequest = $current_request;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $config, $module_id, $module_definition) {
    return new static(
      $config,
      $module_id,
      $module_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('sample_rest_resource'),
      $container->get('current_user'),
      $container->get('request_stack')->getCurrentRequest()
    );
  }
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
    public function post($data) {
      
      
      $database = \Drupal::database();

      // Post the data on the database like that
      $table_name = "some_table_in_the_DB";
      $query = $database->insert($table_name)
        ->fields(['data'])
        ->values(['data' => json_encode($data)])
        ->execute();
    
      $response = new ResourceResponse(http_response_code(201));
      $response->addCacheableDependency(http_response_code(201));
      return $response;

    }

}