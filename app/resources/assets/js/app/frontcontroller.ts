import "reflect-metadata";
import container from "./inversify.config";
import {UsersController} from "./controllers/UsersController";
import ServerRequestFactory from "../shared/http/request/factories/ServerRequestFactory";

alert(container.get(UsersController).getUsers());

alert(
    container
        .get(ServerRequestFactory)
        .createGetXmlRequest('api/vi/products')
);