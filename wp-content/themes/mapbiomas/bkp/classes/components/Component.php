<?php

abstract class Component {
  private string $name;
  private array $properties;

  public function __construct(array $properties = [])
  {
    $name = get_class($this);
    $name = lcfirst($name);
    $name = preg_replace('/[A-Z]/', '-$0', $name);
    $name = strtolower($name);

    $this->name = $name;
    $this->properties = $properties;
  }

  public function __toString(): string {
    extract($this->properties);

    ob_start();
    include __DIR__ . '/../../components/' . $this->name . '.php';
    
    return ob_get_clean();
  }
}
