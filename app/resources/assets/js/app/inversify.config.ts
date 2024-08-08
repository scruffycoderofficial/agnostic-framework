import { Container } from "inversify";
import { UsersController } from "./controllers/UsersController";
import { UsersUseCase } from "./usecases/UsersUseCase";
import ServerRequestFactory from "../shared/http/request/factories/ServerRequestFactory";

const  container = new Container();

// Core configurations
container.bind<ServerRequestFactory>(ServerRequestFactory).toSelf();

// Application configurations
container.bind<UsersController>(UsersController).toSelf();
container.bind<UsersUseCase>(UsersUseCase).toSelf();

export default container;