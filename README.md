# Predator

A fast and functional PHP Webframework experiment

## Design Goals

Predator is meant to be a small, lean framework for microservices in PHP. It is intended to have as few dependencies as possible, to be able to be kept in one person's head, and to be highly performant, scalable, and adhere as closely as possible to a Functional Programming Paradigm.

That doesn't mean there won't be Objects, but Object Orientation is not a serious feature. However, sometimes an object is the best way to do something, and if that is the case, then we'll use one.

1. Functional First - Everything is designed to use the Functional Programming Paradigm wherever it makes sense to do so. This means there is a greater emphasis on pure-ish functions and a distaste for mutating global state. In some cases, mutating state is necessary and desirable, but that's more rare than you think.
2. Performant - Predator should be lean and mean.
3. Unopinionated - The framework should provide the user with the minimal number of tools needed for them to define the functionality of their application. Bells, whistles, meta-programming or any of that clever nonsense is a no-go. The only exception is when we have to overcome some limitation or design flaw in PHP (less likely than you think). 
4. Not a big-idea-framework. Predator is a small-idea framework, intended to build out small microservices that need to perform like the dickens. This is not a kitchen-sink framework. Predator is more a component library than a framework.
5. Be open to contributions. We want programmers in the wild, shipping actual code, to be able to contribute with the least amount of fuss and hassle. We want to be welcoming to all, and useable by all, without exception.
