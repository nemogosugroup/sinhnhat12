import UserRepository from '@backend/api/user/index';
import RoleRepository from '@backend/api/role';
import ProjectRepository from '@backend/api/project';
import langRepository from '@backend/api/lang/index';
import mapRepository from '@backend/api/map/index';
const repositories = {
	user: UserRepository,
	role: RoleRepository,
	project: ProjectRepository,
	lang: langRepository,
	map: mapRepository,
}
const RepositoryFactory = {
	get: name => repositories[name]
}
export default RepositoryFactory